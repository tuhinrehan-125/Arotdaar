<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";
    // public $timestamps = true;

    protected $filable = [

        'name',
        'description',
        'delete_status'
    ];

    public function SubCategories()
    {
        return $this->hasMany(SubCategory::class,'category_id');
    }

    public function Products()
    {
        return $this->hasMany(Products::class,'category_id');
    }
}
