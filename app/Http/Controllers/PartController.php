<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function create(Request $request)
    {
        $part = $request->post();
        Part::create([
            'date_admission' => date('Y-m-d'),
            'type_parts_id' => $part['type_parts_id'],
            'units' => $part['units'],
        ]);
    }
}
