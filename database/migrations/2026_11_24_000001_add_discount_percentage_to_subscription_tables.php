<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('subscription_tiers') && !Schema::hasColumn('subscription_tiers', 'discount_percentage')) {
            Schema::table('subscription_tiers', function (Blueprint $table) {
                $table->decimal('discount_percentage', 5, 2)->default(0)->nullable()->after('promo_badge');
            });
        }

        if (Schema::hasTable('subscription_tiers_pendings') && !Schema::hasColumn('subscription_tiers_pendings', 'discount_percentage')) {
            Schema::table('subscription_tiers_pendings', function (Blueprint $table) {
                $table->decimal('discount_percentage', 5, 2)->default(0)->nullable()->after('promo_badge');
            });
        }

        if (Schema::hasTable('subscription_sub_tiers') && !Schema::hasColumn('subscription_sub_tiers', 'discount_percentage')) {
            Schema::table('subscription_sub_tiers', function (Blueprint $table) {
                $table->decimal('discount_percentage', 5, 2)->default(0)->nullable()->after('promo_badge');
            });
        }

        if (Schema::hasTable('subscription_sub_tiers_pendings') && !Schema::hasColumn('subscription_sub_tiers_pendings', 'discount_percentage')) {
            Schema::table('subscription_sub_tiers_pendings', function (Blueprint $table) {
                $table->decimal('discount_percentage', 5, 2)->default(0)->nullable()->after('promo_badge');
            });
        }

        if (Schema::hasTable('subscription_plans') && !Schema::hasColumn('subscription_plans', 'discount_percentage')) {
            Schema::table('subscription_plans', function (Blueprint $table) {
                $table->decimal('discount_percentage', 5, 2)->default(0)->nullable()->after('price_usd');
            });
        }

        if (Schema::hasTable('subscription_plans_pendings') && !Schema::hasColumn('subscription_plans_pendings', 'discount_percentage')) {
            Schema::table('subscription_plans_pendings', function (Blueprint $table) {
                $table->decimal('discount_percentage', 5, 2)->default(0)->nullable()->after('price_usd');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'subscription_tiers',
            'subscription_tiers_pendings',
            'subscription_sub_tiers',
            'subscription_sub_tiers_pendings',
            'subscription_plans',
            'subscription_plans_pendings',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'discount_percentage')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->dropColumn('discount_percentage');
                });
            }
        }
    }
};

