<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionEquipment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public static function recursive($group_id, $id)
    {
        PositionEquipment::create([
            'group_id' => $group_id,
            'equipment_id' => $id,
        ]);

        $equipments = Equipment::where('parent_equipment_id', $id)->get('id')->toArray();

        foreach ($equipments as $equipment)
        {
            self::recursive($group_id, $equipment);
        }
    }
}
