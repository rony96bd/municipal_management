<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\Service\Service;
use App\Models\Service\SingleService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $page_title = 'সেবা সমূহ';
        $services = Service::with(['singleServices' => function ($query) {
            $query->orderBy('order', 'asc'); // Order the related single services
        }])->orderBy('order', 'asc') // Order the main services
            ->get();

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
        while (Service::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }
        // Save the new representative's data
        $servvice = new Service();
        $servvice->service_name = $request->service_name;
        $servvice->service_description = $request->service_description;
        $servvice->page_url = $pageUrl;
        $servvice->save();

        // Redirect with a success message
        return redirect()->route('services')
            ->with('success', "সফলভাবে '{$request->service_name}' সেবা যুক্ত হয়েছে");
    }

    public function edit($service_id)
    {
        $page_title = 'সেবার তথ্য ইডিট করুন';
        $service = Service::findOrFail($service_id);
        return view('dashboard.services.create-service', compact('page_title', 'service'));
    }
    public function update(Request $request, $service_id)
    {
        // Validation rules
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'required|string|max:255',
            'page_url' => 'required|string|alpha_dash|max:255',
        ]);

        $servvice = Service::findOrFail($service_id);
        // Get the original page_url from the request
        $pageUrl = $request->page_url;

        // Check if the page_url exists for any other representative, excluding the current one
        $existingRepresentative = Service::where('page_url', $pageUrl)
            ->where('service_id', '!=', $service_id) // Exclude the current representative's ID
            ->first();

        if ($existingRepresentative) {
            // If the page_url exists for another representative, append a counter
            $originalUrl = $pageUrl;
            $counter = 1;

            // Find a unique page_url by appending a counter
            while (Service::where('page_url', $pageUrl)->exists()) {
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
        return redirect()->route('services')
            ->with('success', "সফলভাবে '{$request->service_name}' সেবা আপডেট হয়েছে");
    }

    public function destroy($service_id)
    {
        $service = Service::findOrFail($service_id); // Find the page by ID
        $servicename = $service->service_name; // Store page name for feedback
        $service->delete(); // Delete the page

        return redirect()->back()->with('success', "'{$servicename}' - সেবা সফলভাবে মুছে ফেলা হয়েছে।");
    }

    // Add single service item under service
    public function configure($page_url)
    {
        $service = Service::where('page_url', $page_url)->firstOrFail(); // Find the page by ID
        $name = $service->service_name; // Store page name for feedback
        $page_title = $name . ' ' . ' - সেবার তথ্য কনফিগারেশন';
        $single_services = SingleService::all();
        return view('dashboard.services.configure', compact('service', 'page_title', 'single_services'));
    }

    public function storesingleservice(Request $request)
    {
        // Validation rules
        $request->validate([
            'service_item_name' => 'required|string|max:255',
            'service_item_description' => 'required|string',
            'page_url' => 'required|string|alpha_dash|max:255',
            'service_id' => 'required|string',
        ]);

        // Check if the service_id has reached the maximum number of posts
        $maxPosts = 4;
        $currentCount = SingleService::where('service_id', $request->service_id)->count();
        if ($currentCount >= $maxPosts) {
            return redirect()->route('services')->with('error', 'একটি সার্ভিস এর বিপরীতে সর্বোচ্চ ৪টি সার্ভিস তৈরি করা যাবে।');
        }

        // Generate unique page_url
        $pageUrl = $request->page_url;
        $originalUrl = $pageUrl;
        $counter = 1;

        // Ensure the page_url is unique
        while (SingleService::where('page_url', $pageUrl)->exists()) {
            $pageUrl = $originalUrl . '-' . $counter;
            $counter++;
        }

        // Save the new service data with the service_id from the parent service
        $service = new SingleService();
        $service->service_item_name = $request->service_item_name;
        $service->service_item_description = $request->service_item_description;
        $service->page_url = $pageUrl;
        $service->service_id = $request->service_id;
        $service->save();

        // Redirect with a success message
        return redirect()->back()
            ->with('success', "সফলভাবে '{$request->service_item_name}' সেবা যুক্ত হয়েছে");
    }


    public function editsingleserviceitem($id)
    {
        $serviceItem = SingleService::findOrFail($id);
        $name = $serviceItem->service_item_name; // Store page name for feedback
        $page_title = $name . ' ' . ' - সেবার তথ্য আপডেট';
        $single_services = SingleService::all();
        return view('dashboard.services.configure', compact('page_title', 'serviceItem', 'single_services'));
    }


    public function singleserviceupdate(Request $request, $id)
    {
        // Validation rules
        $request->validate([
            'service_item_name' => 'required|string|max:255',
            'service_item_description' => 'required|string',
            'page_url' => 'required|string|alpha_dash|max:255',
            'service_id' => 'required|string',
        ]);

        $service = SingleService::findOrFail($id);
        // Get the original page_url from the request
        $pageUrl = $request->page_url;

        // Check if the page_url exists for any other representative, excluding the current one
        $existingRepresentative = SingleService::where('page_url', $pageUrl)
            ->where('id', '!=', $id) // Exclude the current representative's ID
            ->first();

        if ($existingRepresentative) {
            // If the page_url exists for another representative, append a counter
            $originalUrl = $pageUrl;
            $counter = 1;

            // Find a unique page_url by appending a counter
            while (SingleService::where('page_url', $pageUrl)->exists()) {
                $pageUrl = $originalUrl . '-' . $counter;
                $counter++;
            }
        }

        // Save the new service data with the service_id from the parent service
        $service->service_item_name = $request->service_item_name;
        $service->service_item_description = $request->service_item_description;
        $service->page_url = $pageUrl;
        $service->service_id = $request->service_id;
        $service->save();

        // Redirect with a success message
        return redirect()->route('services')
            ->with('success', "সফলভাবে '{$request->service_item_name}' সেবা আপডেট হয়েছে");
    }

    public function deletesingleservice($id)
    {
        $SingleService = SingleService::findOrFail($id);
        $serviceitemname = $SingleService->service_item_name; // Store page name for feedback
        $SingleService->delete(); // Delete the page
        return redirect()->back()->with('success', "'{$serviceitemname}' - সেবা সফলভাবে মুছে ফেলা হয়েছে।");
    }

    // In your Controller (e.g., OfficialsController)
    public function updateServiceOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = Service::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }

    // In your Controller (e.g., OfficialsController)
    public function updateSingleServiceOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = SingleService::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }
}
