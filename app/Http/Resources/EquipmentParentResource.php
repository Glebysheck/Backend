<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentParentResource extends JsonResource
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
                ("http://192.168.0.117:8080" . $this->image_plan_reference) : $this->image_plan_reference,
        ];
    }
}