<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTerminiTreningaDatumToDani extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('termini_treninga', function (Blueprint $table) {
            $table->renameColumn('datum', 'datum_od');
            $table->json('dani')->after('opis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('termini_treninga', function (Blueprint $table) {
            $table->dropColumn('dani');
            $table->renameColumn('datum_od', 'datum');
        });
    }
}
