<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration {
    public function up() {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('expert_id')->constrained();
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by', 20)->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('favorites');
    }
}
