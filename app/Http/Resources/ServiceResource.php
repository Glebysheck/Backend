<?php

namespace App\Http\Resources;

use App\Models\Equipment;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'equipment_name' => Equipment::where('service_id', $this->id)->first()['equipment_name'],
            'list_files' => InstructionReferenceResource::collection($this->lists),
        ];
    }
}
