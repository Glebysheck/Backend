<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartResource;
use App\Models\MeasureUnits;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $part = Part::where('type_parts_id', $request->all()['type_parts_id'])->get();
        return PartResource::collection($part);
    }

    public function create(Request $request)
    {
        $part = $request->post();
        if ($request->has('measure_units_id'))
        {
            Part::create([
                'date_admission' => date('Y-m-d'),
                'type_parts_id' => $part['type_parts_id'],
                'measure_units_id' => $part['measure_units_id'],
                'units' => is_null($part['units']) ?
                    null : $part['units'] * MeasureUnits::find($part['measure_units_id'])['correlation'],
                'status_part_id' => 1,
            ]);
        }
        else
        {
            for ($i = 1; $i <= $part['units']; $i++)
            {
                Part::create([
                    'date_admission' => date('Y-m-d'),
                    'type_parts_id' => $part['type_parts_id'],
                    'status_part_id' => 1,
                ]);
            }
        }

    }

    public function delete(Request $request)
    {
        Part::destroy($request->all()['id']);
    }
}
