<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_description', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name')->index();
            $table->string('section');
            $table->text('description')->nullable();
            $table->string('game_type')->nullable();
            $table->string('category')->nullable();
            $table->string('devices');
            $table->text('tournaments')->nullable();
            $table->text('additional')->nullable();
            $table->text('engaging_social_description')->nullable();
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
        Schema::dropIfExists('game_description');
    }
}
