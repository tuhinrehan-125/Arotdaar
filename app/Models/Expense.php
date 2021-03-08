<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_for', 'amount', 'ref_no', 'exp_date', 'exp_cat_id', 'note'
    ];

    public function ExpenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'exp_cat_id');
    }
}
