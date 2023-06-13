<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeMeasureUnitsResource;
use App\Models\TypeMeasureUnits;
use Illuminate\Http\Request;

class TypeMeasureUnitsController extends Controller
{
    public function index()
    {
        $type_measure_units = TypeMeasureUnits::all();
        return TypeMeasureUnitsResource::collection($type_measure_units);
    }

    public function create(Request $request)
    {
        TypeMeasureUnits::create([
            'name' => $request->post()['name']
        ]);
    }
}
