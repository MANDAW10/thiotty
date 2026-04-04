<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::latest()->paginate(12);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|url',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        GalleryItem::create($request->all());

        return redirect()->route('admin.gallery.index')->with('success', 'Image ajoutée à la galerie.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $request->validate([
            'image' => 'required|url',
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $gallery->update($request->all());

        return redirect()->route('admin.gallery.index')->with('success', 'Image mise à jour.');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Image supprimée.');
    }
}
