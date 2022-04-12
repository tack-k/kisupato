<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationSitesTable extends Migration {
    public function up() {
        Schema::create('information_sites', function (Blueprint $table) {
            $table->id();
            $table->string('title', '50');
            $table->text('description');
            $table->string('status', '1');
            $table->dateTimeTz('reserved_at')->nullable();
            $table->dateTimeTz('posted_at')->nullable();
            $table->dateTimeTz('created_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTimeTz('updated_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTimeTz('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('information_sites');
    }
}
