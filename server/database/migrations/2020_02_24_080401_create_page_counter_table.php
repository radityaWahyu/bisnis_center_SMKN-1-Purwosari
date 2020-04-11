<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_counter', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('ip_address');
            $table->string('browser');
            $table->enum('type',['pages','item','news']);
            $table->uuidMorphs('view');
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
        Schema::dropIfExists('page_counter');
    }
}
