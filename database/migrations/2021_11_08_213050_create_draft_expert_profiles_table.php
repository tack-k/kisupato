<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftExpertProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_expert_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_id');
            $table->string('status', 5)->nullable();
            $table->string('nickname', 20)->nullable();
            $table->string('profile_image', 255);
            $table->text('self_introduction')->nullable();
            $table->text('activity_title')->nullable();
            $table->text('activity_content')->nullable();
            $table->tinyInteger('saved_flag');
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
        Schema::dropIfExists('draft_expert_profiles');
    }
}
