<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_paid= $this->Payment()->sum('payment_amount');
        $Orders= $this->Orders();
        $total_sell= $Orders->sum('grand_total');
        $total_due= $Orders->where('status','pending')->sum('grand_total');
        $givenadvance= $this->Advance()->where('advance_type','given')->sum('amount');
        $takenadvance= $this->Advance()->where('advance_type','taken')->sum('amount');
        $due= $givenadvance-$takenadvance;
        return [
            'id' => $this->id,
            'client_name' => $this->name,
            'client_name' => $this->name,
            'phone_no' => $this->mobile_no,
            'paid'=> round($total_paid),
            'sell'=> round($total_sell),
            'due'=> round($total_due-$total_paid),
            'advance_due' => $due,
        ];
    }
}
