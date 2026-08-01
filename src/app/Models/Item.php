<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image_path',
        'brand',
        'condition_id',
        'sold_at',
    ];
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
