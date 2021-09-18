<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name', 20)->index();
            $table->string('first_name', 20)->index();
            $table->string('last_name_kana', 20)->index();
            $table->string('first_name_kana', 20)->index();
            $table->string('email')->unique();
            $table->dateTimeTz('email_verified_at')->nullable();
            $table->string('tel', 20);
            $table->string('postal_code', 7);
            $table->string('region', 10)->index();
            $table->string('city', 10)->index();
            $table->string('street', 20);
            $table->string('building', 30)->nullable();
            $table->unsignedTinyInteger('gender');
            $table->date('birthday', );
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
