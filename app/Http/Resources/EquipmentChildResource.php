<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentChildResource extends JsonResource
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
            'position_on_plan' => $this->position_on_plan,
            'equipment_name' => $this->equipment_name,
            'service' => !(is_null($this->service_id)),
            'service_id' => $this->service_id,
            'have_equipment' => (bool)$this->have_equipment,
        ];
    }
}
