<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $givenadvance= $this->Advance()->where('advance_type','given')->sum('amount');
        $takenadvance= $this->Advance()->where('advance_type','taken')->sum('amount');
        $due= $givenadvance-$takenadvance;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'mobile_no' => $this->mobile_no,
            'company_name' => $this->company_name,
            'nid_no' => $this->nid_no,
            'commission_rate' => $this->commission_rate,
            'due' => $due,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
