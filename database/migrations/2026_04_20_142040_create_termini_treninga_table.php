<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminiTreningaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termini_treninga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moderator_id')->constrained('moderators')->onDelete('cascade');
            $table->string('naziv');
            $table->text('opis')->nullable();
            $table->date('datum');
            $table->time('vrijeme_od');
            $table->time('vrijeme_do');
            $table->unsignedInteger('max_mjesta')->default(20);
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
        Schema::dropIfExists('termini_treninga');
    }
}
