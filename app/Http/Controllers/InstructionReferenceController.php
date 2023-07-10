<?php

namespace App\Http\Controllers;

use App\Models\InstructionReference;
use Illuminate\Http\Request;

class InstructionReferenceController extends Controller
{
    public function create(Request $request)
    {
        $file = $request->post();
        $path = $request->file('file')->store('instruction_reference_by_service', ['disk' => 'public']);

        InstructionReference::create([
            'service_id' => $file['service_id'],
            'image_plan_reference' => isset($path) ? "/storage/" . $path : $path,
        ]);
    }

    public function delete(Request $request)
    {
        InstructionReference::destroy($request->all()['id']);
    }
}
