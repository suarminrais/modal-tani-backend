<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
            "name",
            "detail",
            "location",
            "start_at",
            "end_at",
            "target_fund"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function growth()
    {
        return $this->hasMany(Growth::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
