<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\gallery\GalleryModel;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return view('dashboard.gallery.gallery');
    }
    public function create()
    {
        $page_title = 'নতুন গ্যালারি যুক্ত করুন';
        return view('dashboard.gallery.create-gallery', compact('page_title'));
    }

    public function store(Request $request)
    {
        // Validate input fields
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'page_url' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240', // Validate images with specific formats
        ]);
        // Save other data to the database
        $page = GalleryModel::create([
            'topic' => $validated['topic'],
            'description' => $validated['description'],
            'page_url' => $validated['page_url'],
        ]);

        // Create a folder for the gallery post using its ID if not exists
        $uploadPath = "uploads/{$page->id}";
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true); // Create folder with proper permissions
        }

        // Initialize an array to store image paths
        $imagePaths = [];

        // Handle image uploads
        if ($request->hasFile('images')) {
            $imageCounter = 1; // Initialize image counter for sequential naming
            foreach ($request->file('images') as $image) {
                // Extract file extension
                $extension = $image->getClientOriginalExtension();

                // Construct a new image name (e.g., uploads-id-1.jpg, uploads-id-2.png, etc.)
                $filename = "uploads-{$page->id}-{$imageCounter}.{$extension}";

                // Move the image to the gallery's folder
                $image->move($uploadPath, $filename);

                // Store image path in the array
                $imagePaths[] = "uploads/{$page->id}/{$filename}";

                // Increment the image counter for the next image
                $imageCounter++;
            }
        }

        // If images were uploaded, update the gallery record with the image paths
        if (!empty($imagePaths)) {
            $page->update([
                'image_path' => json_encode($imagePaths), // Store image paths as JSON in the database
            ]);
        }

        return redirect()->back()->with('success', 'Gallery post created successfully with images!');
    }
}
