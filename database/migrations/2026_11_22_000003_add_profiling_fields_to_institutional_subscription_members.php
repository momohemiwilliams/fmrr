<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('institutional_subscription_members', function (Blueprint $table) {
            if (!Schema::hasColumn('institutional_subscription_members', 'role')) {
                $table->string('role', 100)->nullable()->after('member_subscription_id');
            }
            if (!Schema::hasColumn('institutional_subscription_members', 'faculty')) {
                $table->string('faculty')->nullable()->after('role');
            }
            if (!Schema::hasColumn('institutional_subscription_members', 'department')) {
                $table->string('department')->nullable()->after('faculty');
            }
            if (!Schema::hasColumn('institutional_subscription_members', 'function')) {
                $table->string('function')->nullable()->after('department');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutional_subscription_members', function (Blueprint $table) {
            if (Schema::hasColumn('institutional_subscription_members', 'function')) {
                $table->dropColumn('function');
            }
            if (Schema::hasColumn('institutional_subscription_members', 'department')) {
                $table->dropColumn('department');
            }
            if (Schema::hasColumn('institutional_subscription_members', 'faculty')) {
                $table->dropColumn('faculty');
            }
            if (Schema::hasColumn('institutional_subscription_members', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
