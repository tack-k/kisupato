<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatrooms extends Migration
{
    public function up()
    {
        Schema::create('chatrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('expert_id')->constrained();
            $table->string('consultation_status', 5)->default('0');
            $table->string('request_status', 10)->default('2');
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatrooms');
    }
}
