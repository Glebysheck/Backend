<?php

namespace App\Http\Resources;

use App\Models\Sort;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
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
            'detail_name' => Sort::find($this->sort_id)['name'],
            'quantity' => $this->quantity,
        ];
    }
}
