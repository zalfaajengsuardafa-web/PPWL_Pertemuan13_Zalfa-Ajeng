<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Pasang middleware lewat constructor.
     * auth   : semua method hanya bisa dibuka setelah login.
     * admin  : semua method kecuali index, listBuku, dan galbuku hanya bisa dibuka oleh admin.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'listBuku', 'galbuku']);
    }

    /**
     * Aturan validasi dipakai bersama oleh store() dan update().
     */
    private function aturan()
    {
        return [
            'judul'      => 'required|string|max:255',
            'penulis'    => 'required|string|max:255',
            'harga'      => 'required|numeric|min:0',
            'tgl_terbit' => 'required|date',
            'jenis_buku' => 'required|in:Fiksi,Nonfiksi',
            'cover'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Menampilkan daftar buku dilengkapi dengan pagination.
     */
    public function index()
    {
        // 1. Ambil data buku dengan pagination (8 item per halaman, diurutkan dari data terbaru)
        $data_buku = Buku::orderBy('id', 'desc')->paginate(8);

        // 2. Hitung total keseluruhan buku
        $jumlah_buku = Buku::count();

        // 3. Hitung nomor urut agar sinkron dengan nomor halaman pagination
        $no = ($data_buku->currentPage() - 1) * $data_buku->perPage();

        // 4. Kirim data ke tampilan Blade
        return view('buku.index', compact('data_buku', 'no', 'jumlah_buku'));
    }

    // Form buat nambah buku
    public function create()
    {
        return view('buku.create');
    }

    // Proses simpan data buku baru + upload sampul
    public function store(Request $request)
    {
        $this->validate($request, $this->aturan());

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->jenis_buku = $request->jenis_buku;

        // Simpan berkas sampul ke storage/app/public/covers, lalu catat alamatnya
        if ($request->hasFile('cover')) {
            $buku->cover = $request->file('cover')->store('covers', 'public');
        }

        $buku->save();

        return redirect()->route('buku.index')->with('pesan', 'Data buku berhasil disimpan');
    }

    // Form buat edit data buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    // Proses update data buku + ganti sampul bila ada berkas baru
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->aturan());

        $buku = Buku::findOrFail($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->jenis_buku = $request->jenis_buku;

        // Bila ada sampul baru: hapus berkas lama, lalu simpan yang baru
        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $buku->cover = $request->file('cover')->store('covers', 'public');
        }

        // PERBAIKAN: Menggunakan save() karena instansiasi properti diset manual
        $buku->save();

        return redirect()->route('buku.index')->with('pesan', 'Data buku berhasil diubah');
    }

    // Hapus data buku beserta berkas sampulnya
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus berkas dulu sebelum barisnya hilang dari database
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('pesan', 'Data buku berhasil dihapus');
    }

    /**
     * Menampilkan halaman daftar buku (Modul SEO).
     */
    public function listBuku()
    {
        $bukus = Buku::whereNotNull('foto')->orderBy('judul')->get();
        return view('buku.list_buku', compact('bukus'));
    }

    /**
     * Menampilkan halaman detail galeri buku berdasarkan slug buku_seo (Modul SEO).
     */
    public function galbuku($title)
    {
        $bukus = Buku::where('buku_seo', $title)->firstOrFail();
        $galeris = $bukus->photos()->orderBy('id', 'desc')->paginate(6);

        return view('buku.detail_buku', compact('bukus', 'galeris'));
    }
}