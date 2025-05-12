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
            $table->float('displacement')->nullable(); // in liters
            $table->integer('cylinders')->nullable();
            $table->integer('power')->nullable(); // in horsepower
            $table->integer('torque')->nullable(); // in Nm
            $table->enum('fuel_type', ['gasoline', 'diesel', 'electric', 'hybrid', 'plug-in hybrid'])->default('gasoline');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('engines');
    }
}
