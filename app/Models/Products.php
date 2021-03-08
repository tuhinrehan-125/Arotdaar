<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'subcategory_id', 'name', 'details', 'unit', 'price', 'image', 'delete_status'

    ];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    public function Unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function getImageAttribute($value)
    {
        return asset('images/'.$value);
    }
}
