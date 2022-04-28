<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailMagazineFlagToExpertsTable extends Migration {
    public function up() {
        Schema::table('experts', function (Blueprint $table) {
            $table->string('mail_magazine_flag', 1);
        });
    }

    public function down() {
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColumn('mail_magazine_flag');
        });
    }
}
