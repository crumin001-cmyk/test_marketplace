<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Condition;

class Condition extends Model
{
    protected $fillable = [
        'name',
        'sort_order',
    ];

    public function condition()
{
    return $this->hasMany(Condition::class);
}


}