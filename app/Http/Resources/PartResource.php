<?php

namespace App\Http\Resources;

use App\Models\MeasureUnits;
use App\Models\StatusPart;
use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
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
            'date_admission' => $this->date_admission,
            'date_mounting' => $this->date_mounting,
            'date_remove' => $this->date_remove,
            'reason_remove' => $this->reason_remove,
            'status_part' => StatusPart::find($this->status_part_id)['status_name'],
            'type_parts_id' => $this->type_parts_id,
            'measure_units_id' => is_null($this->measure_units_id) ?
                null : MeasureUnits::find($this->measure_units_id)['name'],
            'position_equipment' => null,
            'units' => is_null($this->units) ?
                null : $this->units / MeasureUnits::find($this->measure_units_id)['correlation']
        ];
    }
}
