<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypePartsResource;
use App\Models\Article;
use App\Models\Manufacturer;
use App\Models\Part;
use App\Models\Sort;
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
        if (Sort::where('name', $type_part['group'])->exists())
        {
            $sort_id = Sort::where('name', $type_part['group'])->first()['id'];
        }
        else
        {
            $sort_id = Sort::create([
                'name' => $type_part['group']
            ])['id'];
        }


        TypePart::create([
            'name' => $type_part['name'],
            'manufacturer_id' => $manufacturer,
            'article_id' => $article,
            'sort_id' => $sort_id,
            'type_measure_units_id' => $request->has('type_measure_units_id') ?
                $type_part['type_measure_units_id'] : null,
        ]);
    }

    public function change(Request $request)
    {
        $type_part_change = $request->post();

        $type_part = TypePart::find($type_part_change['id']);
        if ($request->has('article') and
            !(Article::where('article_value', $type_part_change['article'])->exists()))
        {
            $type_part->article_id = Article::create([
                'article_value' => $type_part_change['article']
            ])['id'];
        }
        elseif ($request->has('name'))
        {
            $type_part->name = $type_part_change['name'];
        }
        elseif ($request->has('price'))
        {
            $type_part->price = $type_part_change['price'];
        }
        elseif ($request->has('manufacture') and
            !(Manufacturer::where('manufacture_name', $type_part_change['manufacture'])->exists()))
        {
            $type_part->name = Manufacturer::create([
                'manufacture_name' => $type_part_change['manufacture']
            ])['id'];
        }

        $type_part->save();
    }

    public function delete(Request $request)
    {
        TypePart::destroy($request->all()['id']);
        Part::where('type_parts_id', $request->all()['id'])->delete();
    }
}
