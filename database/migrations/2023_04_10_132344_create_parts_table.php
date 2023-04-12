<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->date('date_admission')->nullable();
            $table->date('date_mounting')->nullable();
            $table->date('date_remove')->nullable();
            $table->text('reason_remove')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('position_equipment_id')->nullable();
            $table->foreign('position_equipment_id')
                ->references('id')
                ->on('position_equipment')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('type_parts_id');
            $table->foreign('type_parts_id')
                ->references('id')
                ->on('type_parts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('barcode')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts');
    }
}
