<?php

namespace App\Http\Controllers;

use App\Http\Resources\SortResource;
use App\Models\Consumable;
use App\Models\Detail;
use App\Models\ListConsumables;
use App\Models\ListDetails;
use App\Models\Part;
use App\Models\Sort;
use App\Models\TypePart;
use Illuminate\Http\Request;

class SortController extends Controller
{
    public function index()
    {
        return SortResource::collection(Sort::orderBy('name')->get());
    }

    public function show(Request $request)
    {
        $group = Sort::find($request->all()['group_id']);
        return new SortResource($group);
    }

    public function create(Request $request)
    {
        Sort::create([
            'name' => $request->post()['name'],
            'type_measure_units_id' => $request->has('type_measure_units_id') ?
                $request->post()['type_measure_units_id'] : null,
        ]);
    }

    public function change(Request $request)
    {
        $sort = Sort::find($request->post()['id']);

        $sort->name = $request->post()['name'];

        $sort->save();
    }

    public function delete(Request $request)
    {
        Sort::destroy($request->all()['id']);
        foreach (TypePart::where('sort_id', $request->all()['id'])->get()->toArray() as $type_part)
        {
            Part::where('type_parts_id', $type_part['id'])->delete();
        }
        TypePart::where('sort_id', $request->all()['id'])->delete();
        foreach (Detail::where('sort_id', $request->all()['id'])->get()->toArray() as $detail)
        {
            ListDetails::where('detail_id', $detail['id'])->delete();
        }
        Detail::where('sort_id', $request->all()['id'])->delete();
        foreach (Consumable::where('sort_id', $request->all()['id'])->get()->toArray() as $detail)
        {
            ListConsumables::where('consumables_id', $detail['id'])->delete();
        }
        Consumable::where('sort_id', $request->all()['id'])->delete();
    }
}
