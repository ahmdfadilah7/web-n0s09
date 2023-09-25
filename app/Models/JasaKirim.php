<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaKirim extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'ongkir'
    ];
}
