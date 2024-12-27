<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $page_title = 'সাইট সেটিংস';

        // Fetch the first site settings record
        $settings = SiteSettings::first();

        return view('dashboard.settings.setting', compact('page_title', 'settings'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'meta_description' => 'nullable|string',
        ]);

        // Fetch the first site settings record or create a new one
        $settings = SiteSettings::firstOrNew();

        $settings->site_name = $request->site_name;
        $settings->meta_description = $request->meta_description;

        // Handle logo upload if provided
        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('site_logos', 'public');
            $settings->site_logo = $logoPath;
        }

        $settings->save();

        return redirect()->route('site-setting')->with('success', 'Site settings updated successfully.');
    }
}
