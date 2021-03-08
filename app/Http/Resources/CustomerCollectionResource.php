<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $total_paid= $this->Collections()->sum('amount');
        $OrderProduct= $this->OrderProduct();
        $total_order= $OrderProduct->sum('total');
        $total_due= $OrderProduct->where('payment_type','Bokeya')->sum('total');
        return [
            'id' => $this->id,
            'customer_name' => $this->name,
            'mobile_no' => $this->mobile_no,
            'paid'=> round($total_paid),
            'ordered'=> round($total_order),
            'due'=> round($total_due-$total_paid)
        ];
    }
}
