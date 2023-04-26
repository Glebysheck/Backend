<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotoReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('image_reference');
            $table->unsignedBigInteger('list_services_id');
            $table->foreign('list_services_id')
                ->references('id')
                ->on('list_services')
                ->onUpdate('cascade')
                ->onDelete('cascade');


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
        Schema::dropIfExists('photo_reports');
    }
}
