<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PostRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AntiSpamAndSettingsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful request creation with submission token.
     */
    public function test_request_creation_succeeds_with_valid_data()
    {
        $user = User::create([
            'name' => 'Alice Requestor',
            'email' => 'alice@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        $token = (string) Str::uuid();

        $response = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), [
            'submission_token' => $token,
            'title' => 'Fresh Campus Orientation 2026',
            'description' => 'Comprehensive detailed description of the orientation event for students.',
            'category' => 'Standard PubMat',
            'priority' => 'High',
            'platforms' => ['Facebook'],
            'post_date' => date('Y-m-d', strtotime('+3 days')),
        ]);

        $response->assertRedirect(route('requestor.requests'));
        $this->assertDatabaseHas('post_requests', [
            'title' => 'Fresh Campus Orientation 2026',
            'requester' => 'Alice Requestor',
        ]);
    }

    /**
     * Test that re-submitting with the same submission_token does not duplicate request.
     */
    public function test_duplicate_submission_token_does_not_create_duplicate()
    {
        $user = User::create([
            'name' => 'Bob Requestor',
            'email' => 'bob@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        $token = (string) Str::uuid();

        $payload = [
            'submission_token' => $token,
            'title' => 'Annual Research Colloquium 2026',
            'description' => 'Full event announcement description for university research presentations.',
            'category' => 'Standard PubMat',
            'priority' => 'Medium',
            'platforms' => ['Facebook', 'LinkedIn'],
            'post_date' => date('Y-m-d', strtotime('+5 days')),
        ];

        // First submission
        $res1 = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), $payload);

        $res1->assertRedirect(route('requestor.requests'));

        // Immediate second submission with identical token (simulating double click)
        $res2 = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), $payload);

        $res2->assertRedirect(route('requestor.requests'));

        // Ensure only ONE request was created in the database
        $count = PostRequest::where('title', 'Annual Research Colloquium 2026')->count();
        $this->assertEquals(1, $count);
    }

    /**
     * Test that duplicate title by the same user within 24 hours is rejected.
     */
    public function test_duplicate_title_by_same_user_is_rejected()
    {
        $user = User::create([
            'name' => 'Charlie Requestor',
            'email' => 'charlie@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        PostRequest::create([
            'title' => 'Leadership Summit 2026',
            'requester' => $user->name,
            'user_id' => $user->id,
            'description' => 'Leadership summit details and student council schedule.',
            'category' => 'Standard PubMat',
            'priority' => 'High',
            'status' => 'Pending Review',
            'platform' => 'Facebook',
            'preferred_date' => date('Y-m-d', strtotime('+4 days')),
        ]);

        // Attempt to submit another request with the same title
        $response = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), [
            'submission_token' => (string) Str::uuid(),
            'title' => 'Leadership Summit 2026',
            'description' => 'A slightly different description about the leadership summit.',
            'category' => 'Standard PubMat',
            'priority' => 'High',
            'platforms' => ['Facebook'],
            'post_date' => date('Y-m-d', strtotime('+4 days')),
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, PostRequest::where('title', 'Leadership Summit 2026')->count());
    }

    /**
     * Test that duplicate content hash within 24 hours is rejected.
     */
    public function test_duplicate_content_hash_is_rejected()
    {
        $user = User::create([
            'name' => 'Daisy Requestor',
            'email' => 'daisy@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        PostRequest::create([
            'title' => 'Inter-Campus Sports Meet',
            'requester' => 'Other User',
            'description' => 'Exact matching description for the athletic championship games.',
            'category' => 'Standard PubMat',
            'priority' => 'High',
            'status' => 'Pending Review',
            'platform' => 'Facebook',
            'preferred_date' => date('Y-m-d', strtotime('+6 days')),
        ]);

        $response = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), [
            'submission_token' => (string) Str::uuid(),
            'title' => 'Inter-Campus Sports Meet',
            'description' => 'Exact matching description for the athletic championship games.',
            'category' => 'Standard PubMat',
            'priority' => 'High',
            'platforms' => ['Facebook'],
            'post_date' => date('Y-m-d', strtotime('+6 days')),
        ]);

        $response->assertSessionHas('error');
    }

    /**
     * Test admin settings does not show System Information or Access Token sections.
     */
    public function test_admin_settings_does_not_contain_system_info_or_access_token()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'admin',
        ]);

        $response = $this->withSession([
            'role' => 'admin',
            'admin_email' => $admin->email,
            'admin_name' => $admin->name,
        ])->get(route('admin.settings'));

        $response->assertStatus(200);

        // Verify "System Information" panel is not in settings
        $response->assertDontSee('System Information');
        $response->assertDontSee('Current environment and configuration');

        // Verify "Access Token" panel / nav is not in settings
        $response->assertDontSee('Access Token');
        $response->assertDontSee('Generate Access Token');
        $response->assertDontSee('kayeLinkInput');

        // Verify kept sections are still there
        $response->assertSee('Admin Account');
        $response->assertSee('Security');
        $response->assertSee('Notification Settings');
        $response->assertSee('AI & API Configuration', false);
    }

    /**
     * Test mobile API rejects duplicate title by the same user within 24h.
     */
    public function test_mobile_api_duplicate_title_is_rejected()
    {
        $user = User::create([
            'name' => 'Eve Mobile User',
            'email' => 'eve@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        PostRequest::create([
            'title' => 'Mobile Hackathon 2026',
            'requester' => $user->name,
            'user_id' => $user->id,
            'description' => 'Original hackathon competition details.',
            'category' => 'Template-Based PubMat',
            'priority' => 'High',
            'status' => 'Pending Review',
            'platform' => 'Facebook',
        ]);

        $response = $this->postJson('/api/create_request.php', [
            'user_id' => $user->id,
            'title' => 'Mobile Hackathon 2026',
            'description' => 'Different description for the hackathon event.',
            'category' => 'Template-Based PubMat',
            'priority' => 'High',
        ]);

        $response->assertStatus(422);
        $this->assertFalse($response->json('success'));
        $this->assertStringContainsString('Duplicate request detected', $response->json('message'));
    }

    /**
     * Test mobile API rejects duplicate content hash within 24h.
     */
    public function test_mobile_api_duplicate_content_is_rejected()
    {
        $user = User::create([
            'name' => 'Frank Mobile User',
            'email' => 'frank@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        PostRequest::create([
            'title' => 'Campus Film Festival',
            'requester' => 'Existing Director',
            'description' => 'Exact duplicate description for student film entries.',
            'category' => 'Standard PubMat',
            'priority' => 'Medium',
            'status' => 'Pending Review',
            'platform' => 'Facebook',
        ]);

        $response = $this->postJson('/api/create_request.php', [
            'user_id' => $user->id,
            'title' => 'Campus Film Festival',
            'description' => 'Exact duplicate description for student film entries.',
            'category' => 'Standard PubMat',
            'priority' => 'Medium',
        ]);

        $response->assertStatus(422);
        $this->assertFalse($response->json('success'));
        $this->assertStringContainsString('Duplicate request detected', $response->json('message'));
    }

    /**
     * Test submitting a request with just a year appended (e.g. "College Week Ceremony 2026")
     * when "College Week Ceremony" already exists is detected and rejected as a duplicate.
     */
    public function test_fuzzy_duplicate_with_year_suffix_is_rejected()
    {
        $user = User::create([
            'name' => 'Grace Requestor',
            'email' => 'grace@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        PostRequest::create([
            'title' => 'College Week Ceremony',
            'requester' => $user->name,
            'user_id' => $user->id,
            'description' => 'College Week Ceremony opening details and stage preparation schedule.',
            'category' => 'Posting with Ready-Made PubMat',
            'priority' => 'Medium',
            'status' => 'Pending Review',
            'platform' => 'Facebook',
            'preferred_date' => date('Y-m-d', strtotime('+3 days')),
        ]);

        // Attempt to submit "College Week Ceremony 2026"
        $response = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), [
            'submission_token' => (string) \Illuminate\Support\Str::uuid(),
            'title' => 'College Week Ceremony 2026',
            'description' => 'College Week Ceremony opening details and stage preparation schedule.',
            'category' => 'Posting with Ready-Made PubMat',
            'priority' => 'Low',
            'platforms' => ['Facebook'],
            'post_date' => date('Y-m-d', strtotime('+3 days')),
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, PostRequest::count());
    }

    /**
     * Test that permuted word order (e.g. "College Ceremony Week" vs "College Week Ceremony") is rejected.
     */
    public function test_permuted_word_order_duplicate_title_is_rejected()
    {
        $user = User::create([
            'name' => 'Henry Requestor',
            'email' => 'henry@nupost.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
            'role' => 'requestor',
        ]);

        PostRequest::create([
            'title' => 'College Week Ceremony',
            'requester' => $user->name,
            'user_id' => $user->id,
            'description' => 'College Week Ceremony details and student program.',
            'category' => 'Posting with Ready-Made PubMat',
            'priority' => 'Medium',
            'status' => 'Pending Review',
            'platform' => 'Facebook',
            'preferred_date' => date('Y-m-d', strtotime('+3 days')),
        ]);

        // Attempt to submit "College Ceremony Week"
        $response = $this->withSession([
            'name' => $user->name,
            'role' => 'requestor',
            'user_id' => $user->id,
        ])->post(route('requestor.requests.store'), [
            'submission_token' => (string) \Illuminate\Support\Str::uuid(),
            'title' => 'College Ceremony Week',
            'description' => 'College Ceremony Week details and student program.',
            'category' => 'Posting with Ready-Made PubMat',
            'priority' => 'Low',
            'platforms' => ['Facebook'],
            'post_date' => date('Y-m-d', strtotime('+3 days')),
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(1, PostRequest::where('requester', $user->name)->count());
    }
}

