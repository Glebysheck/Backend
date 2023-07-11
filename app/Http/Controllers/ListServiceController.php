<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartsByServiceResource;
use App\Models\ListService;
use App\Models\MeasureUnits;
use App\Models\Part;
use App\Models\Sort;
use App\Models\TypePart;
use Illuminate\Http\Request;

class ListServiceController extends Controller
{
    public function create(Request $request)
    {
        $service = $request->post();
        ListService::create([
            'user_id' => 1,
            'position_equipment_id' => $service['position_equipment_id'],
            'date_service' => date('Y-m-d'),
            'planned' => $service['planned'],
            'overdue' => 0,
        ]);
    }
    public function add_parts(Request $request)
    {
        $part = $request->post();
        if ($part['quantity'] > PartsByServiceResource::collection(TypePart::find($part['id']))['quantity'])
        {
            return response('Absent', 406);
        }
        if (is_null(Sort::find(TypePart::find($part['id']))['type_measure_units_id']))
        {
            $detail = Part::where('type_parts_id', $part['id'])->orderby('created_at', 'desc')->first();

            $detail->list_services_id = $part['list_services_id'];
            $detail->date_mounting = date('Y-m-d');
        }
        else
        {
            Part::create([
                'date_admission' => date('Y-m-d'),
                'type_parts_id' => $part['type_parts_id'],
                'measure_units_id' => $part['measure_units_id'],
                'units' => $part['units'] * MeasureUnits::find($part['measure_units_id'])['correlation'],
                'status_part_id' => 1,
            ]);
        }
        return response('OK', 200);
    }
}
