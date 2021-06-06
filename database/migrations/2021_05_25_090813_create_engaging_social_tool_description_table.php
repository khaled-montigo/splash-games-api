<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEngagingSocialToolDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engaging_social_tool_description', function (Blueprint $table) {
            $table->id();
            $table->foreignId('engaging_social_tool_id')->references('id')->on('engaging_social_tools')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title')->index();
            $table->text('description');
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
        Schema::dropIfExists('engaging_social_tool_description');
    }
}
