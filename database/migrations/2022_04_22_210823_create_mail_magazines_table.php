<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailMagazinesTable extends Migration {
    public function up() {
        Schema::create('mail_magazines', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('status', 1);
            $table->dateTimeTz('posted_at')->nullable();
            $table->dateTimeTz('reserved_at')->nullable();
            $table->string('send_user', 1)->nullable();
            $table->string('send_expert', 1)->nullable();
            $table->string('target_user', 1)->nullable();
            $table->string('target_expert', 1)->nullable();
            $table->unsignedBigInteger('use_sent_count')->nullable();
            $table->unsignedBigInteger('expert_sent_count')->nullable();
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('mail_magazines');
    }
}
