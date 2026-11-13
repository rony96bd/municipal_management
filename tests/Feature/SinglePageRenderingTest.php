<?php

namespace Tests\Feature;

use App\Models\notice\NoticeModel;
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
        $response->assertSee('detail-card');
        $response->assertSee('detail-lightbox');
        $response->assertSee('id="detail-lightbox-overlay"', false);
    }

    public function test_notice_page_renders_successfully_with_embedded_styles(): void
    {
        $notice = NoticeModel::create([
            'topic' => 'উচ্ছেদ অভিযান নোটিশ',
            'page_url' => 'notice-216172',
            'description' => '<p>উচ্ছেদ অভিযান সংক্রান্ত জরুরি নোটিশ</p>',
            'file_path' => 'attestments/test_notice.pdf',
        ]);

        $response = $this->get('/notice/' . $notice->page_url);

        $response->assertStatus(200);
        $response->assertSee('উচ্ছেদ অভিযান নোটিশ');
        $response->assertSee('উচ্ছেদ অভিযান সংক্রান্ত জরুরি নোটিশ');
        $response->assertSee('detail-card');
        $response->assertSee('detail-lightbox');
        $response->assertSee('id="detail-lightbox-overlay"', false);
    }

    public function test_fallback_asset_routes_serve_css_and_js_successfully(): void
    {
        $cssResponse = $this->get('/css/detail-card.css');
        $cssResponse->assertStatus(200);
        $this->assertStringContainsString('text/css', $cssResponse->headers->get('Content-Type'));
        $this->assertStringContainsString('.detail-card', $cssResponse->getContent());

        $jsResponse = $this->get('/js/detail-lightbox.js');
        $jsResponse->assertStatus(200);
        $this->assertStringContainsString('javascript', $jsResponse->headers->get('Content-Type'));
        $this->assertStringContainsString('detail-lightbox-overlay', $jsResponse->getContent());
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
        $response->assertDontSee('<script>alert("XSS")</script>', false);
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
