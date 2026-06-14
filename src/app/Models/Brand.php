<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Brand extends Model
{
    protected $fillable = [
        'name',
    ];

    public function brand()
    {
    return $this->hasMany(Brand::class);
    }

}

