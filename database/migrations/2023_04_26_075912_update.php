<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('position_equipment', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->after('id');
            $table->unsignedBigInteger('locations_id')->nullable()->after('status_equipment_id');
            $table->foreign('locations_id')
                ->references('id')
                ->on('locations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('parts', function (Blueprint $table) {
            $table->unsignedBigInteger('list_services_id')->after('barcode');
            $table->foreign('list_services_id')
                ->references('id')
                ->on('list_services')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dropForeign('parts_position_equipment_id_foreign');
            $table->dropColumn('position_equipment_id');
        });

        Schema::table('list_services', function (Blueprint $table) {
            $table->boolean('planned')->default(0)->after('date_service');
            $table->boolean('overdue')->after('date_service');
            $table->boolean('verified')->nullable()->after('date_service');
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
