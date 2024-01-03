<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('short_description');
            $table->text('description');
            $table->integer('max_team')->default(2);
            $table->unsignedBigInteger('comittee_id');
            $table->integer('price');
            $table->json('sub_tema');
            $table->integer('is_active')->default(0);
            $table->integer('is_group')->default(1);
            $table->string('guidebook')->nullable();
            $table->enum('category', ['Competition', 'Tournament'])->default('Competition');
            $table->string('logo');
            $table->string('wa_link');
            $table->string('embed_link')->nullable();
            $table->json('stage');
            $table->timestamps();

            $table->foreign('comittee_id')
                    ->references('id')
                    ->on('comittees')
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
        Schema::dropIfExists('programs');
    }
}
