<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailMagazineFlagToUsersTable extends Migration {
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mail_magazine_flag', 1);
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mail_magazine_flag');
        });
    }
}
