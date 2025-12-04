<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $page_title = 'পোস্ট সমূহ';
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('dashboard.posts.index', compact('page_title', 'posts'));
    }

    public function create()
    {
        $page_title = 'নতুন পোস্ট লিখুন';

        return view('dashboard.posts.create', compact('page_title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images_order' => 'nullable|string',
        ]);

        // অটো-জেনারেটেড ইউনিক page_url (slug)
        $baseSlug = Str::slug($validated['title'] ?? 'post');
        $pageUrl = $this->generateUniqueSlug($baseSlug);

        // প্রথমে পোস্ট তৈরি করি (main image_path এখন খালি রাখছি বা প্রথম ছবিটি সেট করব)
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'image_path' => null,
            'page_url' => $pageUrl,
        ]);

        // একাধিক ছবি আপলোড
        if ($request->hasFile('images')) {
            $order = 1;
            $files = $request->file('images');
            $files = $this->sortFilesByOrder($files, $request->input('images_order'));

            foreach ($files as $image) {
                if (!$image->isValid()) {
                    continue;
                }
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/posts'), $fileName);
                $imagePath = 'uploads/posts/' . $fileName;

                // প্রথম ছবিটাকে main image হিসেবে রাখি
                if ($order === 1) {
                    $post->image_path = $imagePath;
                    $post->save();
                }

                $post->images()->create([
                    'image_path' => $imagePath,
                    'order' => $order,
                ]);

                $order++;
            }
        }

        return redirect()->route('posts.index')->with('success', 'পোস্ট প্রকাশ করা হয়েছে।');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $page_title = 'পোস্ট সম্পাদনা করুন';

        return view('dashboard.posts.create', compact('page_title', 'post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images_order' => 'nullable|string',
        ]);
        $post->title = $validated['title'];
        $post->content = $validated['content'] ?? null;

        // যদি আগে page_url না থাকে বা ফাঁকা থাকে, তাহলে অটো-জেনারেট করি
        if (!$post->page_url) {
            $baseSlug = Str::slug($validated['title'] ?? 'post');
            $post->page_url = $this->generateUniqueSlug($baseSlug, $post->id);
        }

        $post->save();

        // নতুন যেসব ছবি দেয়া হবে সেগুলো আগেরগুলোর পর থেকে যোগ করব
        if ($request->hasFile('images')) {
            $lastOrder = $post->images()->max('order') ?? 0;
            $order = $lastOrder + 1;

            $files = $request->file('images');
            $files = $this->sortFilesByOrder($files, $request->input('images_order'));

            foreach ($files as $image) {
                if (!$image->isValid()) {
                    continue;
                }
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/posts'), $fileName);
                $imagePath = 'uploads/posts/' . $fileName;

                // যদি main image না থাকে তবে প্রথম নতুন ছবিটাই main image হিসেবে সেট করি
                if (!$post->image_path) {
                    $post->image_path = $imagePath;
                    $post->save();
                }

                $post->images()->create([
                    'image_path' => $imagePath,
                    'order' => $order,
                ]);

                $order++;
            }
        }

        return redirect()->route('posts.index')->with('success', 'পোস্ট আপডেট করা হয়েছে।');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $title = $post->title;
        $post->delete();

        return redirect()->back()->with('success', "'{$title}' পোস্টটি মুছে ফেলা হয়েছে।");
    }

    private function generateUniqueSlug(string $baseSlug, ?int $excludeId = null): string
    {
        $slug = $baseSlug ?: 'post';
        $originalSlug = $slug;
        $counter = 2;

        while (
            Post::where('page_url', $slug)
                ->when($excludeId, function ($query) use ($excludeId) {
                    return $query->where('id', '!=', $excludeId);
                })
                ->exists()
        ) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * নতুন আপলোডকৃত ফাইলগুলোর অর্ডার ফর্ম থেকে আসা images_order অনুযায়ী সাজানো
     */
    private function sortFilesByOrder(array $files, ?string $orderString): array
    {
        if (!$orderString || empty($files)) {
            return $files;
        }

        $orderNames = array_values(array_filter(explode(',', $orderString)));
        if (empty($orderNames)) {
            return $files;
        }

        usort($files, function ($a, $b) use ($orderNames) {
            $nameA = $a->getClientOriginalName();
            $nameB = $b->getClientOriginalName();

            $posA = array_search($nameA, $orderNames, true);
            $posB = array_search($nameB, $orderNames, true);

            $posA = $posA === false ? PHP_INT_MAX : $posA;
            $posB = $posB === false ? PHP_INT_MAX : $posB;

            return $posA <=> $posB;
        });

        return $files;
    }
}


