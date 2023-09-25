<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategoriproduk_id',
        'nama',
        'slug',
        'harga_modal',
        'harga_jual',
        'stok',
        'deskripsi',
        'gambar',
        'gambar_1',
        'gambar_2',
        'gambar_3',
        'gambar_4',
    ];
}
