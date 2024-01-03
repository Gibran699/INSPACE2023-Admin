<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWinnerToProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {

            // $table->foreign('winner_user_1')
            //         ->references('id')
            //         ->on('users')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');
            // $table->foreign('winner_team_1')
            //         ->references('id')
            //         ->on('teams')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');

            // $table->foreign('winner_user_2')
            //         ->references('id')
            //         ->on('users')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');
            // $table->foreign('winner_team_2')
            //         ->references('id')
            //         ->on('teams')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');

            // $table->foreign('winner_user_3')
            //         ->references('id')
            //         ->on('users')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');
            // $table->foreign('winner_team_3')
            //         ->references('id')
            //         ->on('teams')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            //
        });
    }
}
