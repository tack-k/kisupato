<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeOther1ToExpertProfilesTable extends Migration {
    public function up() {
        Schema::table('expert_profiles', function (Blueprint $table) {
            $table->double('latitude', 8, 6);
            $table->double('longitude', 9, 6);
        });
    }

    public function down() {
        Schema::table('expert_profiles', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
