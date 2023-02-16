<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title',150)->required();
            $table->tinyInteger('rooms_num')->unsigned();
            $table->tinyInteger('beds_num')->unsigned();
            $table->tinyInteger('baths_num')->unsigned();
            $table->text('description')->required();
            $table->decimal('price')->required();
            $table->smallInteger('mq')->unsigned();
            $table->string('image', 255)->required();
            $table->string('full_address', 255)->required();
            $table->decimal('latitude')->required();
            $table->decimal('longitude')->required();
            $table->boolean('is_visible')->default(true);
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
        Schema::dropIfExists('apartments');
    }
};
