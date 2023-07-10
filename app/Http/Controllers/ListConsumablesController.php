<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsumableResource;
use App\Http\Resources\ListSortsResource;
use App\Models\ListConsumables;
use App\Models\Consumable;
use App\Models\Sort;
use Illuminate\Http\Request;

class ListConsumablesController extends Controller
{
    public function index()
    {
        $data = [];
        foreach (Sort::whereNotNull('type_measure_units_id')->get() as $consumable)
        {
            $data['data'][] = new ListSortsResource($consumable);
        }
        return $data;
    }

    public function show(Request $request)
    {
        $data = [];
        foreach (ListConsumables::where('service_id', $request->all()['service_id'])->get() as $detail)
        {
            $data['data'][] = new ConsumableResource(Consumable::find($detail['detail_id']));
        }
        return $data;
    }

    public function create(Request $request)
    {
        $list_consumable = $request->post();
        $consumable = Consumable::create([
            'sort_id' => $list_consumable['sort_id'],
            'quantity' => $list_consumable['quantity'],
        ]);

        ListConsumables::create([
            'service_id' => $list_consumable['service_id'],
            'сonsumables_id' => $consumable['id'],
        ]);
    }
}
