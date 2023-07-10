<?php

namespace App\Http\Resources;

use App\Models\Manufacturer;
use App\Models\MeasureUnits;
use App\Models\Part;
use App\Models\Sort;
use Illuminate\Http\Resources\Json\JsonResource;

class PartsByServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quantity = 0;
        foreach (Part::where('type_parts_id', $this->id)->get()->toArray() as $part)
        {
            if ($part['units'] != null)
            {
                $quantity += $part['units'];
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'manufacturer' => !is_null($this->manufacturer_id) ?
                Manufacturer::find($this->manufacturer_id)['manufacture_name'] : null,
            'quantity' => is_null(Sort::find($this->sort_id)['type_measure_units_id']) ?
                Part::where('type_parts_id', $this->id)->count() :
                $quantity / MeasureUnits::where('type_measure_units_id',
                    Sort::find($this->sort_id)['type_measure_units_id'])
                    ->first()['correlation'],
        ];
    }
}
