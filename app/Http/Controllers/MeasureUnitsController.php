<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeasureUnitsResource;
use App\Models\MeasureUnits;
use Illuminate\Http\Request;

class MeasureUnitsController extends Controller
{
    public function index()
    {
        $measure_units = MeasureUnits::all();
        return MeasureUnitsResource::collection($measure_units);
    }

    public function create(Request $request)
    {
        $measure_units = $request->post();
        MeasureUnits::create([
            'name' => $measure_units['name'],
            'correlation' => $measure_units['correlation'],
            'type_measure_units_id' => $measure_units['type_measure_units_id'],
        ]);
    }
}
