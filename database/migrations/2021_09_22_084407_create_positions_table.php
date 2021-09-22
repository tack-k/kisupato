<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
