<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManufacturerResource;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $data = ['data' => []];
        foreach (Manufacturer::all() as $manufacturer)
        {
            $data['data'][] = $manufacturer['manufacture_name'];
        }
        return $data;
    }
}
