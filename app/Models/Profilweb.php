<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profilweb extends Model
{
    use HasFactory;

    protected $table = 'profilwebs'; 

    protected $fillable = [
        'judul', 'sub_judul',
    ];
}
