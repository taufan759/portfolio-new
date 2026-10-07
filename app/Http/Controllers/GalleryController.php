<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public const PER_PAGE = 24;

    public function index()
    {
        return view('gallery.index', [
            'items' => GalleryItem::listed()->paginate(self::PER_PAGE),
        ]);
    }
}
