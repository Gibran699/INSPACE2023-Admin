<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStageStatusToProgramTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_team', function (Blueprint $table) {
            $table->enum('stage_1_status', ['passed','eliminated','checking'])->default('checking')->after('payment_proof');
            $table->enum('stage_2_status', ['passed','eliminated','checking'])->default('checking')->after('stage_1_status');
            $table->enum('stage_3_status', ['passed','eliminated','checking'])->default('checking')->after('stage_2_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_team', function (Blueprint $table) {
            //
        });
    }
}
