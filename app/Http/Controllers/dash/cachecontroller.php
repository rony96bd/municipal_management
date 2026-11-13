<?php

namespace App\Http\Controllers\dash;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Process;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class cachecontroller extends Controller
{
    public function clearCache(Request $request)
    {
        $lock = Cache::lock('clear-cache-lock', 10);
        if (!$lock->get()) {
            return response()->json([
                'status' => 'success',
                'messages' => ['Cache clear already in progress.'],
            ]);
        }

        try {
            $messages = [];

            Artisan::call('optimize:clear');
            $messages[] = 'Application cache cleared successfully.';

            // Safely attempt LiteSpeed cache clear without raw shell_exec
            try {
                $result = Process::timeout(5)->run(['lscachectl', 'clear']);
                if ($result->successful()) {
                    $messages[] = 'Server cache cleared successfully.';
                } else {
                    $messages[] = 'Server cache clear skipped (lscachectl unavailable).';
                }
            } catch (\Throwable $e) {
                $messages[] = 'Server cache clear skipped.';
            }

            return response()->json([
                'status' => 'success',
                'messages' => $messages,
            ]);
        } finally {
            $lock->release();
        }
    }
}
