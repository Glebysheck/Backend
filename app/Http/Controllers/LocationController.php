<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationParentResource;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function create(Request $request)
    {
        $location = $request->post();

        Location::create([
            'name_location' => $location['name_location'],
            'parent_location_id' => $location['parent_location_id'] != 0 ? $location['parent_location_id'] : null,
        ]);
    }

    public function index(Request $request)
    {
        $location = Location::where('parent_location_id', $request->all()['id'] != 0 ? $request->all()['id'] : null)->get();
        return LocationResource::collection($location);
    }

    public function show(Request $request)
    {
        $location = Location::find($request->all()['id']);
        return new LocationParentResource($location);
    }

    public function split_location(Request $request)
    {
        $location = Location::find($request->post()['id']);

        $location->have_child_location = true;

        $location->save();
    }

    public function fix(Request $request)
    {
        $location = Location::find($request->post()['id']);

        $location->have_child_location = false;

        $location->save();
    }

    public function change(Request $request)
    {
        $location = Location::find($request->post()['id']);

        $location->name_location = $request->post()['name_location'];

        $location->save();
    }

    public function delete(Request $request)
    {
        Location::destroy($request->all()['id']);
        Location::where('parent_location_id', $request->all()['id'])->delete();
    }
}
