<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRequestFinishedAtToChatroomsTable extends Migration {
    public function up()
    {
        Schema::table('chatrooms', function (Blueprint $table) {
            $table->dateTimeTz('request_finished_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('chatrooms', function (Blueprint $table) {
            $table->dropColumn('request_finished_at');
        });
    }
}
