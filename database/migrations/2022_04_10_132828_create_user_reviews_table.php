<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReviewsTable extends Migration {
    public function up() {
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chatroom_id')->constrained();
            $table->foreignId('expert_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('comment')->nullable();
            $table->float('evaluation', 2, 1);
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('user_reviews');
    }
}
