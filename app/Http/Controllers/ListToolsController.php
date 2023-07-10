<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListToolsResource;
use App\Http\Resources\ToolResource;
use App\Models\ListTools;
use App\Models\Tool;
use Illuminate\Http\Request;

class ListToolsController extends Controller
{
    public function index()
    {
        $data = ['data' => []];
        foreach (Tool::all() as $tool)
        {
            if (!in_array($tool['tool_name'], $data['data']))
            {
                $data['data'][] = $tool['tool_name'];
            }
        }
        return $data;
    }

    public function show(Request $request)
    {
        $data = [];
        foreach (ListTools::where('service_id', $request->all()['service_id'])->get() as $tool)
        {
            $data['data'][] = new ToolResource(Tool::find($tool['tool_id']));
        }
        return $data;
    }

    public function create(Request $request)
    {
        $list_tools = $request->post();
        $tool = Tool::create([
            'tool_name' => $list_tools['tool_name'],
            'quantity' => $list_tools['quantity'],
        ]);

        ListTools::create([
            'service_id' => $list_tools['service_id'],
            'tool_id' => $tool['id'],
        ]);
    }

    public function delete(Request $request)
    {
        Tool::destroy($request->all()['id']);
        ListTools::where('tool_id', $request->all()['id'])->delete();
    }
}
