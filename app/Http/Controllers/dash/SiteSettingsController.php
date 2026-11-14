<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        // Validate the incoming request
        $request->validate([
            'site_name' => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:150',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'site_banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'primary_color' => 'nullable|string|max:7',  // Hex color validation
            'secondary_color' => 'nullable|string|max:7',
            'paragraph_color' => 'nullable|string|max:7',
            'danger_color' => 'nullable|string|max:7',
            'alert_color' => 'nullable|string|max:7',
            'success_color' => 'nullable|string|max:7',
            'warning_color' => 'nullable|string|max:7',
            'background_gray' => 'nullable|string|max:7',
            'google_font' => 'nullable|string|max:255',  // Google font validation
        ]);

        // Fetch the first site settings record or create a new one
        $settings = SiteSettings::firstOrNew();
        $optimizer = new \App\Services\ImageOptimizer();

        // Set basic fields
        $settings->site_name = $request->site_name;
        $settings->meta_description = $request->meta_description;

        // Handle logo upload if provided
        if ($request->hasFile('site_logo')) {
            // Unlink the existing logo if it exists
            if ($settings->site_logo && File::exists(public_path($settings->site_logo))) {
                File::delete(public_path($settings->site_logo));
            }
            $logo = $request->file('site_logo');
            $logoExt = strtolower($logo->getClientOriginalExtension() ?: 'png');
            $logoName = 'site_logo_' . time() . '.' . $logoExt;
            $targetPath = public_path('images/site-settings/' . $logoName);
            $optimizer->optimizeUploadedFile($logo, $targetPath);
            $settings->site_logo = 'images/site-settings/' . $logoName;
        }

        // Handle banner upload if provided
        if ($request->hasFile('site_banner')) {
            // Unlink the existing banner if it exists
            if ($settings->site_banner && File::exists(public_path($settings->site_banner))) {
                File::delete(public_path($settings->site_banner));
            }
            $banner = $request->file('site_banner');
            $bannerExt = strtolower($banner->getClientOriginalExtension() ?: 'jpg');
            $bannerName = 'site_banner_' . time() . '.' . $bannerExt;
            $targetPath = public_path('images/site-settings/' . $bannerName);
            $optimizer->optimizeUploadedFile($banner, $targetPath);
            $settings->site_banner = 'images/site-settings/' . $bannerName;
        }

        // Set color fields
        $settings->primary_color = $request->primary_color ?? $settings->primary_color;
        $settings->secondary_color = $request->secondary_color ?? $settings->secondary_color;
        $settings->paragraph_color = $request->paragraph_color ?? $settings->paragraph_color;
        $settings->danger_color = $request->danger_color ?? $settings->danger_color;
        $settings->alert_color = $request->alert_color ?? $settings->alert_color;
        $settings->success_color = $request->success_color ?? $settings->success_color;
        $settings->warning_color = $request->warning_color ?? $settings->warning_color;
        $settings->background_gray = $request->background_gray ?? $settings->background_gray;

        // Handle Google Font selection
        $settings->google_font = $request->google_font ?? 'Tiro Bangla';

        // Save the settings
        $settings->save();

        return redirect()->route('site-setting')->with('success', 'Site settings updated successfully.');
    }

    // Method to reset (delete) the site settings along with the images
    public function reset()
    {
        // Fetch the first site settings record
        $settings = SiteSettings::first();

        // If the settings exist, proceed to delete
        if ($settings) {
            // Delete the images from the public folder if they exist
            if ($settings->site_logo && File::exists(public_path($settings->site_logo))) {
                File::delete(public_path($settings->site_logo));
            }

            if ($settings->site_banner && File::exists(public_path($settings->site_banner))) {
                File::delete(public_path($settings->site_banner));
            }

            // Now, delete the settings from the database
            $settings->delete();

            // Redirect back with a success message
            return redirect()->route('site-setting')->with('success', 'Site settings and images have been reset.');
        }

        // If no settings found, show an error message
        return redirect()->route('site-setting')->with('error', 'No site settings found to reset.');
    }
}
