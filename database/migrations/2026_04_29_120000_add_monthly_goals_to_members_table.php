<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonthlyGoalsToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedSmallInteger('monthly_goal_visits')->default(20)->after('is_admin');
            $table->unsignedSmallInteger('monthly_goal_minutes')->default(1800)->after('monthly_goal_visits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['monthly_goal_visits', 'monthly_goal_minutes']);
        });
    }
}
