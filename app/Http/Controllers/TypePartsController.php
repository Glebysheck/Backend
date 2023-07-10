<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartsByServiceResource;
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
            $type_parts = TypePart::where('sort_id', $request->all()['group_id'])->get();

        return TypePartsResource::collection($type_parts);
    }

    public function show(Request $request)
    {
        $type_part = TypePart::find($request->all()['id']);
        return new TypePartsResource($type_part);
    }

    public function show_by_service()
    {
        $type_parts = TypePart::all();
        return PartsByServiceResource::collection($type_parts);

    }

    public function create(Request $request)
    {
        $type_part = $request->post();

        if ($type_part['manufacturer'] != null)
        {
            if (Manufacturer::where('manufacture_name', $type_part['manufacturer'])->exists())
            {
                $manufacturer = Manufacturer::where('manufacture_name', $type_part['manufacturer'])->first()['id'];
            }
            else
            {
                $manufacturer = Manufacturer::create([
                    'manufacture_name' => $type_part['manufacturer']
                ])['id'];
            }
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
            'sort_id' => $type_part['group_id'],
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
        elseif ($request->has('manufacturer'))
        {
            if (Manufacturer::where('manufacture_name', $type_part_change['manufacturer'])->exists())
            {
                $type_part->manufacturer_id = Manufacturer::where('manufacture_name', $type_part['manufacturer'])
                    ->first()['id'];
            }
            else
            {
                $type_part->manufacturer_id = Manufacturer::create([
                    'manufacture_name' => $type_part_change['manufacturer']
                ])['id'];
            }
        }

        $type_part->save();
    }

    public function delete(Request $request)
    {
        TypePart::destroy($request->all()['id']);
        Part::where('type_parts_id', $request->all()['id'])->delete();
    }
}
