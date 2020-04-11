<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartementIsPublishToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->uuid('departement')->after('user');
            $table->boolean('is_publish')->default(true)->after('departement');
            $table->foreign('departement')->references('id')->on('departements')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_departement_foreign');
            $table->dropColumn('departement');
            $table->dropColumn('is_publish');
        });
    }
}
