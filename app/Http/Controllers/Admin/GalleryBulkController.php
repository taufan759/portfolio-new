<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Support\Images;
use Illuminate\Http\Request;

class GalleryBulkController extends Controller
{
    /** Upload many photos at once; captions and dates can be added afterwards by editing each one. */
    public function store(Request $request)
    {
        $request->validate([
            'photos' => 'required|array|max:30',
            'photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:8192',
            'title' => 'nullable|string|max:200',
            'title_id' => 'nullable|string|max:200',
            'location' => 'nullable|string|max:160',
            'taken_at' => 'nullable|date',
        ]);

        $count = 0;
        foreach ($request->file('photos') as $file) {
            GalleryItem::create([
                'image' => Images::storeWebp($file),
                'title' => $request->input('title') ?: null,
                'title_id' => $request->input('title_id') ?: null,
                'location' => $request->input('location') ?: null,
                'taken_at' => $request->input('taken_at') ?: null,
                'is_published' => true,
            ]);
            $count++;
        }

        return redirect()->route('admin.index', 'gallery')->with('status', "{$count} photo(s) uploaded.");
    }
}
