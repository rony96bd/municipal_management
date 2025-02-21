<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\notice\NoticeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function index()
    {
        $page_title = "নোটিশ";
        $notices = NoticeModel::orderBy('order', 'asc')->get();
        return view('dashboard.notice.notice', compact('page_title', 'notices'));
    }

    public function createnotice()
    {
        $page_title = "নোটিশ যুক্ত করুন";
        return view('dashboard.notice.create-notice', compact('page_title'));
    }

    public function store(Request $request)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string', // Description can be null
            'file_upload' => 'nullable|mimes:pdf,doc,docx,csv,xls,xlsx|max:2048', // File can be null
        ]);

        $tableName = 'notices'; // Replace with your table name
        $nextInsertId = DB::select("SHOW TABLE STATUS LIKE '$tableName'")[0]->Auto_increment;
        $randomNumbers = mt_rand(1000, 9999); // Random 4-digit number
        $page_url = $nextInsertId . $randomNumbers;

        $official = new NoticeModel();
        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generate unique file name
            $file->move('attestments', $fileName); // Save to public/attestments
            $filePath = 'attestments/' . $fileName; // Save relative path for database
            $official->file_path = $filePath; // Save the file path or null if no file uploaded
        }

        $official->topic = $validatedData['topic'];
        $official->description = $validatedData['description'] ?? null; // Save null if not provided
        $official->page_url =  $page_url;
        $official->save();

        // Redirect back with success message
        return redirect()->route('notice')->with('success', "সফলভাবে {$request->topic} কর্মকর্তা যুক্ত হয়েছে");
    }

    public function edit($id)
    {
        $page_title = 'নোটিশ সম্পাদনা করুন';
        $page = NoticeModel::findOrFail($id);
        return view('dashboard.notice.create-notice', compact('page_title', 'page'));
    }
    public function update(Request $request, $id)
    {
        $notice = NoticeModel::findOrFail($id);
        // Validate the form input
        $validatedData = $request->validate([
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string', // Description can be null
            'file_upload' => 'nullable|mimes:pdf,doc,docx,csv,xls,xlsx|max:2048', // File can be null
        ]);

        // Handle file upload if present
        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generate unique file name
            $file->move('attestments', $fileName); // Save to public/attestments
            $filePath = 'attestments/' . $fileName; // Save relative path for database
        }

        // Save form data to the database
        $notice->topic = $validatedData['topic'];
        $notice->description = $validatedData['description'] ?? null; // Save null if not provided
        $notice->file_path = $filePath; // Save the file path or null if no file uploaded
        $notice->save();

        // Redirect back with success message
        return redirect()->route('notice')->with('success', "সফলভাবে {$request->topic} নোটিশ আপডেট হয়েছে");
    }

    public function deleteAttestment($id)
    {
        $notice = NoticeModel::findOrFail($id);

        if ($notice->file_path && file_exists(public_path($notice->file_path))) {
            unlink(public_path($notice->file_path));
        }

        $notice->file_path = null;
        $notice->save();

        return redirect()->back()->with('success', 'ফাইল ডিলিট করা হয়েছে।');
    }
    public function delete($id)
    {
        $notice = NoticeModel::findOrFail($id);
        $name = $notice->topic; // Store page name for feedback
        $notice->delete(); // Delete the page
        return redirect()->back()->with('success', "'{$name}' নোটিশটি মুছে ফেলা হয়েছে।");
    }


    private function generateUniqueUrl($url, $excludeId = null)
    {
        $originalUrl = $url;
        $counter = 2;

        while (
            NoticeModel::where('page_url', $url)
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

    // In your Controller (e.g., OfficialsController)
    public function updateNoticeOrder(Request $request)
    {
        $orderedIds = $request->input('orderedIds'); // This is the list of IDs from the client-side

        // Loop through the ordered IDs and update the 'order' field
        foreach ($orderedIds as $index => $id) {
            $official = NoticeModel::find($id); // Find the official by ID
            if ($official) {
                $official->order = $index + 1; // Assuming 'order' is the field you want to update
                $official->save(); // Save the updated order
            }
        }

        return response()->json(['success' => true]);
    }
}
