<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObavijestiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obavijesti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moderator_id')->constrained('moderators')->onDelete('cascade');
            $table->string('naslov');
            $table->text('sadrzaj');
            $table->enum('tip', ['info', 'vazno', 'upozorenje'])->default('info');
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
        Schema::dropIfExists('obavijesti');
    }
}
