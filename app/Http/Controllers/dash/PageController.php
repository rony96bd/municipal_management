<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\page\createpage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function pagelist(Request $request)
    {
        $page_title = 'পাতা সমূহ';
        $search = $request->input('search'); // Get the search query

        // If there is a search query, filter the pages
        if ($search) {
            $pages = createpage::where('page_name', 'like', '%' . $search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            // If no search query, get all pages
            $pages = createpage::orderBy('created_at', 'desc')->paginate(20);
        }

        return view('dashboard.pages.pages', compact('page_title', 'pages', 'search'));
    }


    public function createpage()
    {
        $page_title = 'নতুন পাতা তৈরি করুন';
        return view('dashboard.pages.create-page', compact('page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required',
            'page_url' => 'required',
            'page_data' => 'required',
            'file_upload' => 'nullable|mimes:pdf,doc,docx,csv,xls,xlsx,jpg,jpeg,png,webp|max:15360',
        ]);

        $page = new createpage();
        $optimizer = new \App\Services\ImageOptimizer();

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'bin');
            $fileName = time() . '_' . Str::random(10) . '.' . $ext;
            $destDir = \App\Services\ImageOptimizer::publicUploadRoot('pages');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }
            $targetPath = $destDir . DIRECTORY_SEPARATOR . $fileName;
            $optimizer->optimizeUploadedFile($file, $targetPath);
            \App\Services\ImageOptimizer::syncToLocalPublic($targetPath, 'pages', $fileName);
            $page->file_path = 'pages/' . $fileName;
        }

        // Generate a unique URL
        $page_url = $this->generateUniqueUrl($request->page_url);
        $page->page_name = $request->page_name;
        $page->page_url = $page_url;
        $page->page_data = $optimizer->optimizeHtmlContent($request->page_data);
        $page->save();

        return redirect()->back()->with('success', "সফলভাবে {$request->page_name} পাতা তৈরি হয়েছে");
    }

    public function edit($id)
    {
        $page_title = 'পাতা সম্পাদনা করুন';
        $page = createpage::findOrFail($id);
        return view('dashboard.pages.create-page', compact('page_title', 'page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'page_name' => 'required',
            'page_url' => 'required',
            'page_data' => 'required',
            'file_upload' => 'nullable|mimes:pdf,doc,docx,csv,xls,xlsx,jpg,jpeg,png,webp|max:15360',
        ]);

        // Find the existing page by ID
        $page = createpage::findOrFail($id);
        $optimizer = new \App\Services\ImageOptimizer();

        $oldFilePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'bin');
            $fileName = time() . '_' . Str::random(10) . '.' . $ext;
            $destDir = \App\Services\ImageOptimizer::publicUploadRoot('pages');
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0775, true);
            }
            $targetPath = $destDir . DIRECTORY_SEPARATOR . $fileName;
            $optimizer->optimizeUploadedFile($file, $targetPath);
            \App\Services\ImageOptimizer::syncToLocalPublic($targetPath, 'pages', $fileName);
            $oldFilePath = $page->file_path;
            $page->file_path = 'pages/' . $fileName;
        }

        // Generate a unique URL excluding the current page ID
        $page_url = $this->generateUniqueUrl($request->page_url, $id);

        // Update the page data
        $page->page_name = $request->page_name;
        $page->page_url = $page_url;
        $page->page_data = $optimizer->optimizeHtmlContent($request->page_data);
        $page->save();

        $this->deleteStoredFile($oldFilePath);

        // Redirect with a success message
        return redirect()->route('pages')->with('success', "সফলভাবে {$request->page_name} পাতা আপডেট হয়েছে");
    }

    /**
     * Generate a unique page URL by appending a counter if needed.
     *
     * @param string $url
     * @param int|null $excludeId
     * @return string
     */
    private function generateUniqueUrl($url, $excludeId = null)
    {
        $originalUrl = $url;
        $counter = 2;

        while (
            createpage::where('page_url', $url)
            ->when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->exists()
        ) {
            $url = "{$originalUrl}-{$counter}";
            $counter++;
        }

        return $url;
    }

    public function deleteAttachment($id)
    {
        $page = createpage::findOrFail($id);
        $oldFilePath = $page->file_path;

        // Remove the file path from the database first
        $page->file_path = null;
        $page->save();

        $this->deleteStoredFile($oldFilePath);

        return redirect()->back()->with('success', 'ফাইল মুছে ফেলা হয়েছে');
    }

    public function destroy($id)
    {
        $page = createpage::findOrFail($id);
        $page_name = $page->page_name;
        $oldFilePath = $page->file_path;
        $page->delete();

        $this->deleteStoredFile($oldFilePath);

        return redirect()->back()->with('success', "{$page_name} পাতা সফলভাবে মুছে ফেলা হয়েছে।");
    }

    private function deleteStoredFile(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $baseDir = realpath(\App\Services\ImageOptimizer::publicUploadRoot('pages'));
        $filePath = realpath(\App\Services\ImageOptimizer::publicUploadRoot($relativePath));

        if ($baseDir && $filePath && str_starts_with($filePath, $baseDir . DIRECTORY_SEPARATOR) && is_file($filePath)) {
            @unlink($filePath);
        }

        $localBase = realpath(public_path('pages'));
        $localFile = realpath(public_path($relativePath));
        if ($localBase && $localFile && str_starts_with($localFile, $localBase . DIRECTORY_SEPARATOR) && is_file($localFile)) {
            @unlink($localFile);
        }
    }


    // In your Controller (e.g., OfficialsController)
    public function updatePageOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = createpage::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }
}
