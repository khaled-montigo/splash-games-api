<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoToolDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_tool_description', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_tool_id')->references('id')->on('promo_tools')->onDelete('cascade');
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
        Schema::dropIfExists('promo_tool_description');
    }
}
