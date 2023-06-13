<?php

namespace App\Http\Controllers;

use App\Models\StatusPart;
use Illuminate\Http\Request;

class StatusPartController extends Controller
{
    public function create(Request $request)
    {
        StatusPart::create([
            'status_name' => $request->post()['status_name'],
        ]);
    }
}
