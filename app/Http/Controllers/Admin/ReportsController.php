<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostRequest;

class ReportsController extends Controller
{
    public function index()
    {
        return view('admin.reports');
    }

    public function export()
    {
        $filter_status   = request('status', 'all');
        $filter_category = request('category', 'all');
        $filter_priority = request('priority', 'all');
        $date_from       = request('date_from', '');
        $date_to         = request('date_to', '');

        $query = PostRequest::query();
        if ($filter_status !== 'all') {
            $status_map = [
                'pending'=>'Pending Review','review'=>'Under Review',
                'approved'=>'Approved','posted'=>'Posted','rejected'=>'Rejected',
            ];
            if (isset($status_map[$filter_status])) $query->where('status',$status_map[$filter_status]);
        }
        if ($filter_category !== 'all') $query->where('category',$filter_category);
        if ($filter_priority !== 'all') $query->where('priority',ucfirst($filter_priority));
        if ($date_from) $query->whereDate('created_at','>=',$date_from);
        if ($date_to)   $query->whereDate('created_at','<=',$date_to);

        $requests = $query->orderByDesc('created_at')->get();

        $filename = 'nupost_report_' . date('Y-m-d') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($requests) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel
            fputs($handle, "\xEF\xBB\xBF");
            // Header row
            fputcsv($handle, ['ID','Request ID','Title','Requestor','Category','Priority','Status','Platforms','Preferred Date','Caption','Submitted']);
            foreach ($requests as $req) {
                $plats = implode(', ', $req->platforms_array ?? []);
                fputcsv($handle, [
                    $req->id,
                    $req->request_id ?? 'N/A',
                    $req->title,
                    $req->requester,
                    $req->category,
                    $req->priority,
                    $req->status,
                    $plats,
                    $req->preferred_date ?? '',
                    $req->caption ?? '',
                    $req->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}