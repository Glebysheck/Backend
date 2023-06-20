<?php

namespace App\Http\Resources;

use App\Models\MeasureUnits;
use App\Models\Part;
use App\Models\TypePart;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\Type;

class SortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quantity_part = 0;
        if (is_null($this->type_measure_units_id))
        {
            foreach (TypePart::where('sort_id', $this->id)->get()->toArray() as $type_part)
            {
                $quantity_part += Part::where('type_parts_id', $type_part['id'])->count();
            }
        }
        else
        {
            foreach (TypePart::where('sort_id', $this->id)->get()->toArray() as $type_part)
            {
                foreach (Part::where('type_parts_id', $type_part['id'])->get()->toArray() as $part)
                {
                    if ($part['units'] != null)
                    {
                        $quantity_part += $part['units'];
                    }
                }
            }
            $quantity_part /= MeasureUnits::where('type_measure_units_id', $this->type_measure_units_id)
                ->first()['correlation'];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity_type_part' => TypePart::where('sort_id', $this->id)->count(),
            'quantity_part' => $quantity_part,
            'measurement_units' => is_null($this->type_measure_units_id) ? 'шт' :
                MeasureUnits::where('type_measure_units_id', $this->type_measure_units_id)
                ->first()['name'],
        ];
    }
}
