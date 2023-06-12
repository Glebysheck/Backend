<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMeasureUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measure_units', function (Blueprint $table) {
            $table->unsignedBigInteger('type_measure_units_id')->after('correlation');
            $table->foreign('type_measure_units_id')
                ->references('id')
                ->on('type_measure_units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('type_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('type_measure_units_id')->after('sort_id')->nullable();
            $table->foreign('type_measure_units_id')
                ->references('id')
                ->on('type_measure_units')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->dropForeign('type_parts_measure_units_id_foreign');
            $table->dropColumn('measure_units_id');
        });

        Schema::table('parts', function (Blueprint $table) {
            $table->unsignedBigInteger('measure_units_id')->after('units')->nullable();
            $table->foreign('measure_units_id')
                ->references('id')
                ->on('measure_units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
