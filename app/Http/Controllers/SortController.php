<?php

namespace App\Http\Controllers;

use App\Http\Resources\SortResource;
use App\Models\Sort;
use Illuminate\Http\Request;

class SortController extends Controller
{
    public function index()
    {
        return SortResource::collection(Sort::orderBy('name')->get());
    }

    public function create(Request $request)
    {
        Sort::create([
            'name' => $request->all()['name']
        ]);
    }
}
