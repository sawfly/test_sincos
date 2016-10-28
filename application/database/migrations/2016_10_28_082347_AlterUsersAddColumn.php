<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'invited_by')) {
            Schema::table('users', function ($table) {
                $table->integer('invited_by')->unsigned()->nullable()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'invited_by')) {
            Schema::table('users', function ($table) {
                $table->dropColumn(['invited_by']);
            });
        }
    }
}
