<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image_path',
        'brand_id',
        'condition_id',
        'sold_at',
    ];
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorite');
    }
}
