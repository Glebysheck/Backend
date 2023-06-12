<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypePartsResource;
use App\Models\Article;
use App\Models\Manufacturer;
use App\Models\Part;
use App\Models\TypePart;
use Illuminate\Http\Request;

class TypePartsController extends Controller
{
    public function index(Request $request)
    {
        $type_parts = array();
        if (is_null($request->has('order')) and $request->all()['order'] == 'missing')
        {
            foreach (TypePart::all()->toArray() as $type_part)
            {
                if (Part::where('type_parts_id', $type_part['id'])->first() != null)
                {
                    $type_parts[] = $type_part;
                }
            }
        }
        else
            $type_parts = TypePart::all();

        return TypePartsResource::collection($type_parts);
    }

    public function show(Request $request)
    {
        $type_part = TypePart::find($request->all()['id']);
        return new TypePartsResource($type_part);
    }

    public function create(Request $request)
    {
        $type_part = $request->post();

        if ($type_part['manufacturer'] != null)
        {
            $manufacturer = Manufacturer::create([
                'manufacture_name' => $type_part['manufacturer']
            ])['id'];
        }
        else
            $manufacturer = null;
        if ($type_part['article'] != null)
        {
            $article = Article::create([
                'article_value' => $type_part['article']
            ])['id'];
        }
        else
            $article = null;


        TypePart::create([
            'name' => $type_part['name'],
            'manufacturer_id' => $manufacturer,
            'article_id' => $article,
        ]);
    }
}
