<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function child()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
