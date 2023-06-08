<?php

namespace App\Http\Resources;

use App\Models\FilesByEquipment;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'equipment_name' => $this->equipment_name,
            'list_image' => FilesByEquipmentResource::collection($this->lists),
        ];
    }
}
