<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];

    public function lists()
    {
        return $this->hasMany(PositionEquipment::class);
    }
}
