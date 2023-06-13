<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Manufacturer;
use App\Models\MeasureUnits;
use App\Models\Part;
use Illuminate\Http\Resources\Json\JsonResource;

class TypePartsResource extends JsonResource
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
            'article' => !is_null($this->article_id) ?
                Article::find($this->article_id)['article_value'] : null,
            'name' => $this->name,
            'price' => $this->price,
            'manufacturer' => !is_null($this->manufacturer_id) ?
                Manufacturer::find($this->manufacturer_id)['manufacture_name'] : null,
            'type_measure_units_id' => $this->type_measure_units_id,
            'measurement_units' => is_null($this->type_measure_units_id) ?
                'шт' : MeasureUnits::where('type_measure_units_id', $this->type_measure_units_id)
                    ->first()['name'],
            'quantity' => is_null($this->type_measure_units_id) ?
                Part::where('type_parts_id', $this->id)->count() :
                $quantity / MeasureUnits::where('type_measure_units_id', $this->type_measure_units_id)
                    ->first()['correlation'],
        ];
    }
}
