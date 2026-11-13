<?php

namespace Tests\Feature;

use App\Models\page\createpage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SinglePageRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_single_page_renders_successfully(): void
    {
        $page = createpage::create([
            'page_name' => 'সিটিজেন চার্টার',
            'page_url' => 'citizen-charter',
            'page_data' => '<p>পৌরসভা সেবা বিবরণী</p>',
        ]);

        $response = $this->get('/page/' . $page->page_url);

        $response->assertStatus(200);
        $response->assertSee('সিটিজেন চার্টার');
        $response->assertSee('পৌরসভা সেবা বিবরণী');
        $response->assertSee('detail-card.css');
        $response->assertSee('detail-lightbox.js');
        $response->assertSee('id="detail-lightbox-overlay"', false);
    }

    public function test_single_page_preserves_base64_document_scans(): void
    {
        $base64Sample = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=';
        $page = createpage::create([
            'page_name' => 'সিটিজেন চার্টার স্ক্যান',
            'page_url' => 'citizen-charter-scan',
            'page_data' => '<p><img src="' . $base64Sample . '" alt="Charter Scan"></p>',
        ]);

        $response = $this->get('/page/' . $page->page_url);

        $response->assertStatus(200);
        $response->assertSee($base64Sample, false);
        $response->assertSee('alt="Charter Scan"', false);
    }

    public function test_single_page_sanitizes_malicious_scripts_in_content(): void
    {
        $page = createpage::create([
            'page_name' => 'সুরক্ষা পরীক্ষা',
            'page_url' => 'security-test',
            'page_data' => '<h2>শিরোনাম</h2><script>alert("XSS")</script><p onclick="steal()">নিরাপদ লেখা</p><img src="javascript:alert(1)" alt="bad">',
        ]);

        $response = $this->get('/page/' . $page->page_url);

        $response->assertStatus(200);
        $response->assertSee('শিরোনাম');
        $response->assertSee('নিরাপদ লেখা');
        $response->assertDontSee('<script>', false);
        $response->assertDontSee('alert("XSS")', false);
        $response->assertDontSee('onclick', false);
        $response->assertDontSee('javascript:alert(1)', false);
    }

    public function test_single_page_renders_tables_with_layout_attributes(): void
    {
        $page = createpage::create([
            'page_name' => 'বাজেট টেবিল',
            'page_url' => 'budget-table',
            'page_data' => '<table border="1" cellpadding="5" align="center" style="border-collapse: collapse;"><tr><th align="center">খাত</th><th>টাকা</th></tr><tr><td>রাজস্ব</td><td>১০০০০</td></tr></table>',
        ]);

        $response = $this->get('/page/' . $page->page_url);

        $response->assertStatus(200);
        $response->assertSee('বাজেট টেবিল');
        $response->assertSee('align="center"', false);
        $response->assertSee('border-collapse', false);
    }
}
