<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('buku_seo')->nullable()->after('judul');
            $table->string('foto')->nullable()->after('penulis');
        });

        DB::table('buku')->select('id', 'judul')->get()->each(function ($buku) {
            DB::table('buku')->where('id', $buku->id)
                ->update(['buku_seo' => Str::slug($buku->judul)]);
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['buku_seo', 'foto']);
        });
    }
};