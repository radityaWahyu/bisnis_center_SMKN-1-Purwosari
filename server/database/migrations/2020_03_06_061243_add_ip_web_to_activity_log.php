<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpWebToActivityLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('properties');
            $table->text('browser_name')->nullable()->after('ip_address');
            $table->text('os_name')->nullable()->after('browser_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('ip_address');
            $table->dropColumn('browser_name');
            $table->dropColumn('os_name');
        });
    }
}
