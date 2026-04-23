<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlikaToObavijestiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obavijesti', function (Blueprint $table) {
            $table->string('slika')->nullable()->after('sadrzaj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obavijesti', function (Blueprint $table) {
            $table->dropColumn('slika');
        });
    }
}
