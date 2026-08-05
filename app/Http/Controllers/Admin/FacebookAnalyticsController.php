<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FacebookAnalyticsController extends Controller
{
    private string $token;
    private string $base = 'https://graph.facebook.com/v21.0';

    public function __construct()
    {
        $this->token = env('FB_PAGE_ACCESS_TOKEN', '');
    }

    /**
     * Build an array of the last 24 months for the dropdown.
     */
    public static function getAvailableMonths(): array
    {
        $months = [];
        for ($i = 0; $i < 24; $i++) {
            $m = Carbon::now()->subMonths($i)->startOfMonth();
            $months[] = [
                'value' => $m->format('Y-m'),
                'label' => $m->format('F Y'),
            ];
        }
        return $months;
    }

    public function index(Request $request)
    {
        // Default to current month
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));

        // Validate format (YYYY-MM)
        if (!preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
            $selectedMonth = Carbon::now()->format('Y-m');
        }

        $monthCarbon = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();

        $fb = $this->getData($selectedMonth);
        $fb['selected_month']    = $selectedMonth;
        $fb['month_label']       = $monthCarbon->format('F Y');
        $fb['available_months']  = self::getAvailableMonths();

        return view('admin.analytics', compact('fb'));
    }

    /**
     * Reusable Facebook HTTP client with SSL bypass for local/XAMPP environments.
     */
    private function fbHttp()
    {
        return Http::withoutVerifying()->timeout(15);
    }

    public function getData(string $selectedMonth = null): array
    {
        if (!$selectedMonth) {
            $selectedMonth = Carbon::now()->format('Y-m');
        }

        $monthCarbon = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        $since = $monthCarbon->copy()->startOfMonth()->format('Y-m-d');
        // Don't go past today
        $until = $monthCarbon->copy()->endOfMonth()->isFuture()
            ? Carbon::now()->format('Y-m-d')
            : $monthCarbon->copy()->endOfMonth()->format('Y-m-d');

        if (!$this->token) {
            return [
                'error'    => 'FB_PAGE_ACCESS_TOKEN missing in .env',
                'pageInfo' => null,
                'metrics'  => null,
                'posts'    => [],
            ];
        }

        try {
            // ── 1. Page basic info ─────────────────────────────────────────
            $pageInfo = Cache::remember('fb_page_info', 300, function () {
                $response = $this->fbHttp()->get("{$this->base}/me", [
                    'fields'       => 'name,id,fan_count,followers_count,link,picture.type(large)',
                    'access_token' => $this->token,
                ]);
                Log::debug('FB Page Info Response', ['status' => $response->status(), 'body' => $response->json()]);
                return $response->json();
            });

            if (isset($pageInfo['error'])) {
                Cache::forget('fb_page_info');
                throw new \Exception($pageInfo['error']['message'] ?? 'Unknown Facebook API error');
            }

            // ── 2. Posts for selected month ────────────────────────────────
            $cacheKey = "fb_posts_{$selectedMonth}";
            $sinceTs  = $monthCarbon->copy()->startOfMonth()->timestamp;
            $untilTs  = $monthCarbon->copy()->endOfMonth()->isFuture()
                ? Carbon::now()->timestamp
                : $monthCarbon->copy()->endOfMonth()->timestamp;

            $postsRes = Cache::remember($cacheKey, 300, function () use ($sinceTs, $untilTs) {
                $response = $this->fbHttp()->get("{$this->base}/me/posts", [
                    'fields'       => 'id,message,story,created_time,full_picture,permalink_url,likes.summary(true),comments.summary(true),shares',
                    'since'        => $sinceTs,
                    'until'        => $untilTs,
                    'limit'        => 100,
                    'access_token' => $this->token,
                ]);
                Log::debug('FB Posts Response', ['status' => $response->status()]);
                return $response->json();
            });

            if (isset($postsRes['error'])) {
                Cache::forget($cacheKey);
                Log::warning('FB Posts API Error', $postsRes['error']);
            }

            $posts = collect($postsRes['data'] ?? [])->values()->all();

            // ── 3. Page Insights for selected month ────────────────────────
            $insightsCacheKey = "fb_insights_{$selectedMonth}";

            $insightsData = Cache::remember($insightsCacheKey, 300, function () use ($since, $until) {
                $response = $this->fbHttp()->get("{$this->base}/me/insights", [
                    'metric'       => 'page_impressions_unique,page_post_engagements',
                    'period'       => 'day',
                    'since'        => $since,
                    'until'        => $until,
                    'access_token' => $this->token,
                ]);
                Log::debug('FB Insights Response', ['status' => $response->status()]);
                return $response->json();
            });

            // Parse insights
            $totalReach      = 0;
            $totalEngagement = 0;
            $dailyReach      = [];
            $dailyEngagement = [];

            if (!empty($insightsData['data'])) {
                foreach ($insightsData['data'] as $metric) {
                    $metricName = $metric['name'] ?? '';
                    $values     = $metric['values'] ?? [];

                    if ($metricName === 'page_impressions_unique') {
                        foreach ($values as $v) {
                            $totalReach += $v['value'] ?? 0;
                            $dailyReach[] = [
                                'date'  => $v['end_time'] ?? '',
                                'value' => $v['value'] ?? 0,
                            ];
                        }
                    }

                    if ($metricName === 'page_post_engagements') {
                        foreach ($values as $v) {
                            $totalEngagement += $v['value'] ?? 0;
                            $dailyEngagement[] = [
                                'date'  => $v['end_time'] ?? '',
                                'value' => $v['value'] ?? 0,
                            ];
                        }
                    }
                }
            }

            // ── 4. Aggregate post metrics ──────────────────────────────────
            $totalLikes    = 0;
            $totalComments = 0;
            $totalShares   = 0;
            foreach ($posts as $p) {
                $totalLikes    += $p['likes']['summary']['total_count']    ?? 0;
                $totalComments += $p['comments']['summary']['total_count'] ?? 0;
                $totalShares   += $p['shares']['count']                    ?? 0;
            }

            $metrics = [
                'page_fans'        => ['total' => $pageInfo['fan_count']       ?? 0, 'daily' => []],
                'followers'        => ['total' => $pageInfo['followers_count'] ?? 0, 'daily' => []],
                'total_reach'      => ['total' => $totalReach,      'daily' => $dailyReach],
                'total_engagement' => ['total' => $totalEngagement, 'daily' => $dailyEngagement],
                'total_likes'      => ['total' => $totalLikes,      'daily' => []],
                'total_comments'   => ['total' => $totalComments,   'daily' => []],
                'total_shares'     => ['total' => $totalShares,     'daily' => []],
                'total_posts'      => ['total' => count($posts),    'daily' => []],
            ];

            return [
                'error'    => null,
                'pageInfo' => $pageInfo,
                'metrics'  => $metrics,
                'posts'    => $posts,
            ];

        } catch (\Exception $e) {
            Log::error('Facebook API Error: ' . $e->getMessage());
            return [
                'error'    => $e->getMessage(),
                'pageInfo' => null,
                'metrics'  => null,
                'posts'    => [],
            ];
        }
    }

    /**
     * Export the current month's FB data as CSV.
     */
    public function exportCsv(Request $request)
    {
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $selectedMonth)) {
            $selectedMonth = Carbon::now()->format('Y-m');
        }

        $fb = $this->getData($selectedMonth);
        $monthLabel = Carbon::createFromFormat('Y-m', $selectedMonth)->format('F_Y');

        $filename = "facebook_analytics_{$monthLabel}.csv";

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($fb, $selectedMonth) {
            $handle = fopen('php://output', 'w');

            // ── Summary section ──────────────────────────────────────────
            fputcsv($handle, ['Facebook Analytics Export']);
            fputcsv($handle, ['Month', Carbon::createFromFormat('Y-m', $selectedMonth)->format('F Y')]);
            fputcsv($handle, ['Page', $fb['pageInfo']['name'] ?? 'N/A']);
            fputcsv($handle, ['Page Likes', $fb['pageInfo']['fan_count'] ?? 0]);
            fputcsv($handle, ['Followers', $fb['pageInfo']['followers_count'] ?? 0]);
            fputcsv($handle, []);

            // ── Metrics summary ──────────────────────────────────────────
            fputcsv($handle, ['Metric', 'Value']);
            fputcsv($handle, ['Total Reach',      $fb['metrics']['total_reach']['total']      ?? 0]);
            fputcsv($handle, ['Total Engagements',$fb['metrics']['total_engagement']['total'] ?? 0]);
            fputcsv($handle, ['Total Likes',      $fb['metrics']['total_likes']['total']      ?? 0]);
            fputcsv($handle, ['Total Comments',   $fb['metrics']['total_comments']['total']   ?? 0]);
            fputcsv($handle, ['Total Shares',     $fb['metrics']['total_shares']['total']     ?? 0]);
            fputcsv($handle, ['Total Posts',      $fb['metrics']['total_posts']['total']      ?? 0]);
            fputcsv($handle, []);

            // ── Daily reach ──────────────────────────────────────────────
            fputcsv($handle, ['Daily Reach (Impressions)']);
            fputcsv($handle, ['Date', 'Reach', 'Engagements']);
            $reachByDate      = collect($fb['metrics']['total_reach']['daily'] ?? [])->keyBy('date');
            $engByDate        = collect($fb['metrics']['total_engagement']['daily'] ?? [])->keyBy('date');
            $allDates         = $reachByDate->keys()->merge($engByDate->keys())->unique()->sort();
            foreach ($allDates as $date) {
                fputcsv($handle, [
                    Carbon::parse($date)->format('Y-m-d'),
                    $reachByDate->get($date)['value'] ?? 0,
                    $engByDate->get($date)['value']   ?? 0,
                ]);
            }
            fputcsv($handle, []);

            // ── Posts breakdown ──────────────────────────────────────────
            fputcsv($handle, ['Posts Breakdown']);
            fputcsv($handle, ['Date', 'Caption', 'Likes', 'Comments', 'Shares', 'URL']);
            foreach ($fb['posts'] ?? [] as $post) {
                fputcsv($handle, [
                    Carbon::parse($post['created_time'])->format('Y-m-d'),
                    mb_substr($post['message'] ?? $post['story'] ?? '', 0, 100),
                    $post['likes']['summary']['total_count']    ?? 0,
                    $post['comments']['summary']['total_count'] ?? 0,
                    $post['shares']['count']                    ?? 0,
                    $post['permalink_url'] ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function refresh(Request $request)
    {
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));

        Cache::forget('fb_page_info');
        Cache::forget("fb_posts_{$selectedMonth}");
        Cache::forget("fb_insights_{$selectedMonth}");

        return redirect()->route('admin.analytics', ['month' => $selectedMonth])
                         ->with('success', '✅ Facebook analytics refreshed!');
    }
}