<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calendar_users', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('calendar_id')->references('id')->on('calendars');
        });

        Schema::table('events', function(Blueprint $table) {
            $table->foreign('calendar_id')->references('id')->on('calendars');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::table('calendars', function(Blueprint $table) {
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calendars', function(Blueprint $table) {
            $table->dropForeign('calendars_owner_id_foreign');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
        });

        Schema::table('events', function(Blueprint $table) {
            $table->dropForeign('events_calendar_id_foreign');
        });

        Schema::table('calendar_users', function(Blueprint $table) {
            $table->dropForeign('calendar_users_calendar_id_foreign');
            $table->dropForeign('calendar_users_user_id_foreign');
        });
    }
}
