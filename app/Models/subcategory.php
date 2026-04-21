<?php

namespace App\Models;

use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{

    protected $fillable = [
        'cat_id',
        'subcatname',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id');
    }
}