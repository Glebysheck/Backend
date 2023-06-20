<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSort extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sorts', function (Blueprint $table) {
            $table->unsignedBigInteger('type_measure_units_id')->after('name')->nullable();
            $table->foreign('type_measure_units_id')
                ->references('id')
                ->on('type_measure_units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('type_parts', function (Blueprint $table) {
            $table->dropForeign('type_parts_type_measure_units_id_foreign');
            $table->dropColumn('type_measure_units_id');
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
