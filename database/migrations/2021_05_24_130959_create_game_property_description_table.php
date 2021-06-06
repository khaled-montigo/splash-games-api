<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePropertyDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_property_description', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_property_id')->references('id')->on('game_properties')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title')->index();
            $table->string('description');
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
        Schema::dropIfExists('game_property_description');
    }
}
