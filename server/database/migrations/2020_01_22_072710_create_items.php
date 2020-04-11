<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image');
            $table->uuid('category');
            $table->uuid('departement');
            $table->uuid('user');
            $table->timestamps();

            $table->foreign('category')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('departement')->references('id')->on('departements')->onDelete('cascade');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
