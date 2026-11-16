<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    private function messages(): array
    {
        return [
            'title.required'       => 'Judul wajib diisi.',
            'title.max'            => 'Judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'picture.image'        => 'File harus berupa gambar.',
            'picture.max'          => 'Ukuran gambar maksimal 1999 KB.',
        ];
    }

    public function index()
    {
        $data = array(
            'id'        => "posts",
            'menu'      => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')
                ->whereNotNull('picture')
                ->orderBy('created_at', 'desc')
                ->paginate(30)
        );
        return view('gallery.index')->with($data);
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required|max:255',
            'description' => 'required',
            'picture'     => 'image|nullable|max:1999'
        ], $this->messages());

        if ($request->hasFile('picture')) {
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filenameSimpan = uniqid() . time() . '.' . $extension;
            $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
        } else {
            $filenameSimpan = null;
        }

        $post = new Post;
        $post->picture     = $filenameSimpan;
        $post->title       = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect()->route('gallery.index')->with('success', 'Berhasil menambahkan data baru');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('gallery.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $this->validate($request, [
            'title'       => 'required|max:255',
            'description' => 'required',
            'picture'     => 'image|nullable|max:1999'
        ], $this->messages());

        if ($request->hasFile('picture')) {
            if ($post->picture) {
                Storage::disk('public')->delete('posts_image/' . $post->picture);
            }
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filenameSimpan = uniqid() . time() . '.' . $extension;
            $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
            $post->picture = $filenameSimpan;
        }

        $post->title       = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect()->route('gallery.index')->with('success', 'Berhasil memperbarui data');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->picture) {
            Storage::disk('public')->delete('posts_image/' . $post->picture);
        }

        $post->delete();

        return redirect()->route('gallery.index')->with('success', 'Berhasil menghapus data');
    }
}