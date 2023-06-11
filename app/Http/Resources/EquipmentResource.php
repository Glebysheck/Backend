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
        if (FilesByEquipment::where('equipment_id', $this->id)->first() != null)
        {
            return [
                'id' => $this->id,
                'equipment_name' => $this->equipment_name,
                'image_plan_reference' => FilesByEquipment::select('image_plan_reference')
                    ->where('equipment_id', $this->id)->first()->toArray()['image_plan_reference']
            ];
        }
        return [
            'id' => $this->id,
            'equipment_name' => $this->equipment_name,
            'image_plan_reference' => null
        ];
    }
}
