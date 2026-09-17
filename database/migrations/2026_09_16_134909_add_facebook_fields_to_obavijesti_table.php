<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Dodaje polja potrebna za automatski uvoz objava sa Facebook stranice:
     * - fb_post_id: ID objave sa Facebooka (sprjecava duple uvoze)
     * - javno: da li se obavijest prikazuje i na naslovnoj stranici (javno, bez logina)
     * Takodjer kreira sistemskog moderatora "Facebook Sync" koji ce biti vlasnik
     * automatski uvezenih obavijesti (moderator_id kolona ostaje NOT NULL, bez izmjene sheme).
     */
    public function up()
    {
        Schema::table('obavijesti', function (Blueprint $table) {
            $table->string('fb_post_id')->nullable()->unique()->after('moderator_id');
            $table->boolean('javno')->default(false)->after('tip');
        });

        DB::table('moderators')->updateOrInsert(
            ['email' => 'facebook-sync@begsfit.ba'],
            [
                'name' => 'Facebook Sync',
                'password' => Hash::make(Str::random(32)),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down()
    {
        Schema::table('obavijesti', function (Blueprint $table) {
            $table->dropColumn(['fb_post_id', 'javno']);
        });
    }
};
