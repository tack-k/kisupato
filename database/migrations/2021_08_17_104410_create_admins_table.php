<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('authority_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('staff_number', 10)->unique();
            $table->string('last_name', 20)->index();
            $table->string('first_name', 20)->index();
            $table->string('last_name_kana', 20)->index();
            $table->string('first_name_kana', 20)->index();
            $table->string('email')->unique();
            $table->dateTimeTz('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('password_init_flag')->default(0);
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
        Schema::dropIfExists('admins');
    }
}
