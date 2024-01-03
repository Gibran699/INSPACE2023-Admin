<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_team', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file_stage_1')->nullable();
            $table->string('file_stage_2')->nullable();
            $table->string('file_stage_3')->nullable();
            $table->string('proposal')->nullable();
            $table->string('originality')->nullable();
            $table->string('result_link')->nullable();
            $table->string('presentation')->nullable();
            $table->string('twibbon')->nullable();
            $table->string('payment_proof')->nullable();
            $table->integer('is_paid')->default(0);
            $table->json('stage_doc')->nullable();
            $table->timestamps();

            $table->foreign('program_id')
                    ->references('id')
                    ->on('programs')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('team_id')
                    ->references('id')
                    ->on('teams')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_team');
    }
}
