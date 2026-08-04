<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
