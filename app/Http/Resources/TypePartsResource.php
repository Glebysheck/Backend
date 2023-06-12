<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypePartsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_id' => $this->article_id,
            'name' => $this->name,
            'price' => $this->price,
            'manufacturer_id' => $this->manufacturer_id,
            'measure_units_id' => $this->measure_units_id,
        ];
    }
}
