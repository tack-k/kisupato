<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeOther1ToCitiesTable extends Migration {
    public function up() {
        Schema::table('cities', function (Blueprint $table) {
            $table->float('latitude', 4, 2);
            $table->float('longitude', 5, 2);
        });
    }

    public function down() {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
