<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string("name");
            $table->boolean("add_new_model_machine")->default(0);
            $table->boolean("add_new_position_machine")->default(0);
            $table->boolean("service")->default(0);
            $table->boolean("view_list_all_parts")->default(0);
            $table->boolean("add_new_part")->default(0);
            $table->boolean("changes_price_part")->default(0);
            $table->boolean("statistics")->default(0);
            $table->boolean("changes_period_planned_service")->default(0);
            $table->boolean("registration_new_users")->default(0);
            $table->boolean("addition_parts")->default(0);

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
        Schema::dropIfExists('roles');
    }
}
