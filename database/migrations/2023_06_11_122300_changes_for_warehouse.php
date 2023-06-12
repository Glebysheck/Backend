<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesForWarehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->unsignedBigInteger('sort_id')->after('id');
            $table->foreign('sort_id')
                ->references('id')
                ->on('sorts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dropColumn('detail_name');
        });

        Schema::table('type_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('sort_id')->after('manufacturer_id');
            $table->foreign('sort_id')
                ->references('id')
                ->on('sorts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('measure_units_id')->after('sort_id')->nullable();
            $table->foreign('measure_units_id')
                ->references('id')
                ->on('measure_units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('parts', function (Blueprint $table) {
            $table->unsignedBigInteger('list_services_id')->nullable()->change();
            $table->unsignedBigInteger('status_part_id')->nullable()->change();
            $table->unsignedBigInteger('units')->after('list_services_id')->nullable();
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
