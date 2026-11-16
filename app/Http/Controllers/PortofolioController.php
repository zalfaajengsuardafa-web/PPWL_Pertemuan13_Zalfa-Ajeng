<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Post;

class PortofolioController extends Controller
{
    public function index()
    {
        $galleries = Post::whereNotNull('picture')->latest()->take(8)->get();
        $bukus     = Buku::latest()->take(6)->get();

        return view('portofolio', compact('galleries', 'bukus'));
    }
}