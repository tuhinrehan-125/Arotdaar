<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'expense_for' => $this->expense_for,
            'amount' => $this->amount,
            'ref_no' => $this->ref_no,
            'exp_date' => $this->exp_date,
            'exp_cat_id' => $this->exp_cat_id,
            'exp_cat_name' => $this->ExpenseCategory ? $this->ExpenseCategory->name : null,
            'monthly_exp' => $this->is_monthly_expense,
            'note' => $this->note,
        ];
    }
}
