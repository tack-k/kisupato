<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeOther1ToExpertProfilesTable extends Migration {
    public function up() {
        Schema::table('expert_profiles', function (Blueprint $table) {
            $table->float('latitude', 8, 6)->nullable();
            $table->float('longitude', 9, 6)->nullable();
        });
    }

    public function down() {
        Schema::table('expert_profiles', function (Blueprint $table) {
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
