<?php

namespace App\Http\Resources;

use App\Models\Equipment;
use App\Models\FilesByEquipment;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionEquipmentDetailResource extends JsonResource
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
            'position_on_plan' => Equipment::find($this->equipment_id)['position_on_plan'],
            'equipment_name' => Equipment::find($this->equipment_id)['equipment_name'],
            'date_last_service' => $this->date_last_service_id,
            'date_planned_service' => $this->date_planned_service_id,
            'service' => !(is_null(Equipment::find($this->equipment_id)['service_id'])),
            'have_equipment' => (bool)Equipment::find($this->equipment_id)['have_equipment'],
        ];
    }
}
