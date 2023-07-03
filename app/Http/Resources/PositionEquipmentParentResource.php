<?php

namespace App\Http\Resources;

use App\Models\Equipment;
use App\Models\FilesByEquipment;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionEquipmentParentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (FilesByEquipment::where('equipment_id', $this->equipment_id)->first() != null)
        {
            return [
                'id' => $this->id,
                'group_id' => $this->group_id,
                'position' => $this->position,
                'equipment_id' => $this->equipment_id,
                'list_image' => FilesByEquipmentResource::collection(Equipment::find($this->equipment_id)->lists),
                'equipment_name' => Equipment::find($this->equipment_id)->equipment_name,
                'position_on_location' => $this->position_on_location,
            ];
        }
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'position' => $this->position,
            'equipment_id' => $this->equipment_id,
            'image' => null,
            'equipment_name' => Equipment::find($this->equipment_id)->equipment_name,
            'position_on_location' => $this->position_on_location,
        ];
    }
}
