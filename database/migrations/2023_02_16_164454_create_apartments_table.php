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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title',150)->required();
            $table->unsignedTinyInteger('rooms_num')->required();
            $table->unsignedTinyInteger('beds_num')->required();
            $table->unsignedTinyInteger('baths_num')->required();
            $table->text('description')->required();
            $table->decimal('price')->required();
            $table->unsignedSmallInteger('mq')->required();
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
