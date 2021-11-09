<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftActivityImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_activity_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_profile_id');
            $table->string('activity_image', 255)->nullable();
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draft_activity_images');
    }
}
