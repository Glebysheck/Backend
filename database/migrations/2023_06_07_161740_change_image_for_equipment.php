<?php

use App\Models\Equipment;
use App\Models\FilesByEquipment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeImageForEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $equipments_image = Equipment::select('id', 'image_plan_reference')
            ->whereNotNull('image_plan_reference')
            ->get()
            ->toArray();

        foreach ($equipments_image as $equip)
        {
            FilesByEquipment::create([
                'equipment_id' => $equip['id'],
                'image_plan_reference' => $equip['image_plan_reference'],
            ]);
        }

        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('image_plan_reference');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
