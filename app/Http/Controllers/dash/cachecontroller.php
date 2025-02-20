<?php

namespace App\Http\Controllers\dash;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class cachecontroller extends Controller
{
    public function clearCache(Request $request)
    {
        dd('test');
        // Initialize messages
        $messages = [];

        // Clear all Laravel caches
        // Artisan::call('cache:clear');
        // Artisan::call('config:clear');
        // Artisan::call('route:clear');
        // Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        $messages[] = 'Application cache cleared successfully.';

        // Clear LiteSpeed server cache
        $clearLiteSpeedCache = shell_exec('lscachectl clear');

        if ($clearLiteSpeedCache !== null) {
            $messages[] = 'Server cache cleared successfully.';
        } else {
            $messages[] = 'Unable to clear server cache.';
        }

        // Return JSON response with messages
        return response()->json([
            'status' => 'success',
            'messages' => $messages
        ]);
    }
}
