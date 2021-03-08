<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => ucfirst($this->name),
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'category_name' => $this->Category->name,
            'subcategory_name' => $this->SubCategory ? $this->SubCategory->name : null,
            'details' => $this->details,
            'image'=>$this->image?$this->image:null
        ];
    }
}
