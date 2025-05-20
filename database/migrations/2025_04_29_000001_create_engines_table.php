<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnginesTable extends Migration
{
    public function up()
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('horsepower')->nullable(); // in horsepower
            $table->string('level')->nullable();
            $table->integer('max_speed')->nullable(); // in km/h
            $table->string('drive_type')->nullable();
            $table->string('engine_type')->nullable();
            $table->boolean('isActive')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('engines');
    }
}
