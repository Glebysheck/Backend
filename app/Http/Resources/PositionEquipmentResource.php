<?php

namespace App\Http\Resources;

use App\Models\Equipment;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionEquipmentResource extends JsonResource
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
            'group_id' => $this->group_id,
            'position' => $this->position,
            'equipment_id' => $this->equipment_id,
            'image' => Equipment::find($this->equipment_id)->image_plan_reference,
            'equipment_name' => Equipment::find($this->equipment_id)->equipment_name,
        ];
    }
}
