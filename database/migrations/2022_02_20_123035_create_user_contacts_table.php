<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContactsTable extends Migration {
    public function up() {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_contact_title_id')->constrained();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name', 20);
            $table->string('email', 255);
            $table->string('tel', 11);
            $table->text('content');
            $table->string('status', 5)->default('0');
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by', 20)->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by', 20)->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by', 20)->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('user_contacts');
    }
}
