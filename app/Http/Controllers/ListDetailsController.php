<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailResource;
use App\Http\Resources\ListSortsResource;
use App\Models\Detail;
use App\Models\ListDetails;
use App\Models\Sort;
use Illuminate\Http\Request;

class ListDetailsController extends Controller
{
    public function index()
    {
        $data = [];
        foreach (Sort::whereNull('type_measure_units_id')->get() as $detail)
        {
            $data['data'][] = new ListSortsResource($detail);
        }
        return $data;
    }

    public function show(Request $request)
    {
        $data = [];
        foreach (ListDetails::where('service_id', $request->all()['service_id'])->get() as $detail)
        {
            $data['data'][] = new DetailResource(Detail::find($detail['detail_id']));
        }
        return $data;
    }

    public function create(Request $request)
    {
        $list_detail = $request->post();
        $detail = Detail::create([
            'sort_id' => $list_detail['sort_id'],
            'quantity' => $list_detail['quantity'],
        ]);

        ListDetails::create([
            'service_id' => $list_detail['service_id'],
            'detail_id' => $detail['id'],
        ]);
    }

    public function delete(Request $request)
    {
        Detail::destroy($request->all()['id']);
        ListDetails::where('detail_id', $request->all()['id'])->delete();
    }
}
