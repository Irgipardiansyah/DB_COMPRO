<?php

// app/Models/Location.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations'; 
    protected $fillable = ['nama_location'];
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}

