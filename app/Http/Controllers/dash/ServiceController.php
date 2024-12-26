<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\service\services;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $page_title = 'সেবা সমূহ';
        $services = services::all();
        return view('dashboard.services.service', compact('page_title', 'services'));
    }
    public function createservice()
    {
        $page_title = 'নতুন সেবা যুক্ত করুন';
        return view('dashboard.services.create-service', compact('page_title'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'required|string|max:255',
            'page_url' => 'required|string|alpha_dash|max:255',
        ]);

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Ensure the page_url is unique
        while (services::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }
        $serviceId = substr(time(), -6);
        // Save the new representative's data
        $servvice = new services();
        $servvice->service_id = $serviceId;
        $servvice->service_name = $request->service_name;
        $servvice->service_description = $request->service_description;
        $servvice->page_url = $pageUrl;
        $servvice->save();

        // Redirect with a success message
        return redirect()->route('services')
            ->with('success', "সফলভাবে '{$request->service_name}' সেবা যুক্ত হয়েছে");
    }

    public function edit($id)
    {
        $page_title = 'সেবার তথ্য ইডিট করুন';
        $service = services::findOrFail($id);
        return view('dashboard.services.create-service', compact('page_title', 'service'));
    }
    public function update(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'required|string|max:255',
            'page_url' => 'required|string|alpha_dash|max:255',
        ]);

        $servvice = services::findOrFail($id);
        // Get the original page_url from the request
        $pageUrl = $request->page_url;

        // Check if the page_url exists for any other representative, excluding the current one
        $existingRepresentative = services::where('page_url', $pageUrl)
            ->where('id', '!=', $id) // Exclude the current representative's ID
            ->first();

        if ($existingRepresentative) {
            // If the page_url exists for another representative, append a counter
            $originalUrl = $pageUrl;
            $counter = 1;

            // Find a unique page_url by appending a counter
            while (services::where('page_url', $pageUrl)->exists()) {
                $pageUrl = $originalUrl . '-' . $counter;
                $counter++;
            }
        }

        // Save the new representative's data
        $servvice->service_name = $request->service_name;
        $servvice->service_description = $request->service_description;
        $servvice->page_url = $pageUrl; // Use the final unique page_url
        $servvice->save();

        // Redirect with a success message
        return redirect()->route('representativeslist')
            ->with('success', "সফলভাবে '{$request->service_name}' সেবা যুক্ত হয়েছে");
    }

    public function destroy($id)
    {
        $service = services::findOrFail($id); // Find the page by ID
        $servicename = $service->service_name; // Store page name for feedback
        $service->delete(); // Delete the page

        return redirect()->back()->with('success', "'{$servicename}' - সেবা সফলভাবে মুছে ফেলা হয়েছে।");
    }

    public function configure($page_url)
    {
        $service = services::where('page_url', $page_url)->firstOrFail(); // Find the page by ID
        $name = $service->service_name; // Store page name for feedback
        $page_title = $name . ' ' . 'সেবার তথ্য কনফিগারেশন';
        return view('dashboard.services.configure', compact('service', 'page_title'));
    }
}
