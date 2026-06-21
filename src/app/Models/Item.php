<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;

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
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
    //public function comments()
    //{
       // return $this->hasMany(Comment::class);
    //}
}
