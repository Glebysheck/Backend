<?php

namespace App\Http\Resources;

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
            'image_plan_reference' => isset($this->image_plan_reference) ?
                ("http://195.161.68.107:8000" . $this->image_plan_reference) : $this->image_plan_reference,
            'list_position' => PositionEquipmentResource::collection($this->lists),
        ];
    }
}
