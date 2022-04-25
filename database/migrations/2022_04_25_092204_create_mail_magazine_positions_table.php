<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMagazinePositionsTable extends Migration {
    public function up() {
        Schema::create('mail_magazine_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mail_magazine_id')->constrained();
            $table->foreignId('position_id')->constrained();
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('mail_magazine_positions');
    }
}
