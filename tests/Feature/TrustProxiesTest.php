<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TrustProxiesTest extends TestCase
{
    public function test_trusted_proxies_resolves_real_client_ip_from_forwarded_for(): void
    {
        Route::get('/test-client-ip', function () {
            return response()->json([
                'ip' => request()->ip(),
            ]);
        });

        $response = $this->withServerVariables([
            'REMOTE_ADDR'          => '10.0.0.1', // Proxy / Cloudflare IP
            'HTTP_X_FORWARDED_FOR' => '203.0.113.195', // Real client IP
        ])->get('/test-client-ip');

        $response->assertStatus(200);
        $response->assertJson(['ip' => '203.0.113.195']);
    }

    public function test_different_client_ips_do_not_share_track_rate_limit_behind_proxy(): void
    {
        $proxyIp = '10.0.0.1';

        // 15 requests from client A behind the proxy
        for ($i = 0; $i < 15; $i++) {
            $this->withServerVariables([
                'REMOTE_ADDR'          => $proxyIp,
                'HTTP_X_FORWARDED_FOR' => '198.51.100.10',
            ])->get(route('attestation.track.index'))->assertStatus(200);
        }

        // 16th request from client A is throttled
        $this->withServerVariables([
            'REMOTE_ADDR'          => $proxyIp,
            'HTTP_X_FORWARDED_FOR' => '198.51.100.10',
        ])->get(route('attestation.track.index'))->assertStatus(429);

        // Meanwhile, client B behind the same proxy gets 200 OK (not throttled!)
        $this->withServerVariables([
            'REMOTE_ADDR'          => $proxyIp,
            'HTTP_X_FORWARDED_FOR' => '198.51.100.20',
        ])->get(route('attestation.track.index'))->assertStatus(200);
    }
}
