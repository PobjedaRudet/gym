<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPromoTipToObavijestiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE obavijesti MODIFY tip ENUM('info','vazno','upozorenje','promo') NOT NULL DEFAULT 'info'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("UPDATE obavijesti SET tip = 'info' WHERE tip = 'promo'");
        DB::statement("ALTER TABLE obavijesti MODIFY tip ENUM('info','vazno','upozorenje') NOT NULL DEFAULT 'info'");
    }
}
