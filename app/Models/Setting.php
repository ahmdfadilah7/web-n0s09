<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_website',
        'email',
        'no_telp',
        'alamat',
        'desk_singkat',
        'judul_header',
        'gambar_header',
        'logo',
        'favicon',
        'bg_login',
        'bg_register',
        'facebook',
        'twitter',
        'instagram',
        'youtube'
    ];
}
