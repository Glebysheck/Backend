<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Manufacturer;
use App\Models\MeasureUnits;
use App\Models\Part;
use App\Models\Sort;
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
        $units = 0;
        foreach (Part::where('type_parts_id', $this->id)->get()->toArray() as $part)
        {
            if ($part['units'] != null)
            {
                $units += $part['units'];
            }
        }

        if (is_null(Sort::find($this->sort_id)['type_measure_units_id']))
        {
            $quantity = Part::where('type_parts_id', $this->id)->whereNull('date_mounting')->count();
        }
        else
        {
            $quantity = $units / MeasureUnits::where('type_measure_units_id',
                    Sort::find($this->sort_id)['type_measure_units_id'])
                    ->first()['correlation'];
        }

        return [
            'id' => $this->id,
            'article' => !is_null($this->article_id) ?
                Article::find($this->article_id)['article_value'] : null,
            'name' => $this->name,
            'price' => $this->price,
            'manufacturer' => !is_null($this->manufacturer_id) ?
                Manufacturer::find($this->manufacturer_id)['manufacture_name'] : null,
            'type_measure_units_id' => Sort::find($this->sort_id)['type_measure_units_id'],
            'measurement_units' => is_null(Sort::find($this->sort_id)['type_measure_units_id']) ?
                'шт' : MeasureUnits::where('type_measure_units_id',
                    Sort::find($this->sort_id)['type_measure_units_id'])
                    ->first()['name'],
            'quantity' => $quantity,
            'list_image' => FilesByPartResource::collection($this->lists),
        ];
    }
}
