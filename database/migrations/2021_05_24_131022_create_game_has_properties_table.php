<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameHasPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_has_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreignId('game_property_id')->references('id')->on('game_properties')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_has_properties');
    }
}
