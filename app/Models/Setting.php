<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['arot_commission', 'bazar_commission','arot_image'];

    public function getArotImageAttribute($value)
    {
        return $value?asset('images/'.$value):null;
    }

}
