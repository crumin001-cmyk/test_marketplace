<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Category extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
