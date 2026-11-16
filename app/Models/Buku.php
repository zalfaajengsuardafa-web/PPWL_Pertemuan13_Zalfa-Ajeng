<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Buku extends Model
{
    use HasFactory;

    // Aku tentuin nama tabelnya secara eksplisit ke tabel 'buku'
    protected $table = 'buku';

    // Kolom-kolom yang boleh diisi secara massal saat simpan/update data
    protected $fillable = [
        'judul',
        'buku_seo',
        'penulis',
        'foto',
        'harga',
        'tgl_terbit',
        'jenis_buku',
        'cover',
    ];

    // Aku ubah tipe data tgl_terbit jadi date/datetime biar format date di Blade ($buku->tgl_terbit->format('d/m/Y')) ga error
    protected $casts = [
        'tgl_terbit' => 'date',
    ];

    // Otomatis mengisi buku_seo (slug) setiap kali data buku dibuat atau diperbarui
    protected static function booted(): void
    {
        static::saving(function (Buku $buku) {
            $buku->buku_seo = Str::slug($buku->judul);
        });
    }

    // Relasi one-to-many: satu buku memiliki banyak foto galeri
    public function photos()
    {
        return $this->hasMany(Galeri::class, 'id_buku', 'id');
    }
}