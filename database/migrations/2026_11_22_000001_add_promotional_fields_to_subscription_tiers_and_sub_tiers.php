<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_tiers', function (Blueprint $table) {
            $table->boolean('is_promotional')->default(false)->after('description');
            $table->string('promo_tab_title')->nullable()->after('is_promotional');
            $table->string('promo_badge')->nullable()->after('promo_tab_title');
            $table->text('promo_features')->nullable()->after('promo_badge');
            $table->dateTime('promo_start_at')->nullable()->after('promo_features');
            $table->dateTime('promo_end_at')->nullable()->after('promo_start_at');
        });

        Schema::table('subscription_tiers_pendings', function (Blueprint $table) {
            $table->boolean('is_promotional')->default(false)->after('description');
            $table->string('promo_tab_title')->nullable()->after('is_promotional');
            $table->string('promo_badge')->nullable()->after('promo_tab_title');
            $table->text('promo_features')->nullable()->after('promo_badge');
            $table->dateTime('promo_start_at')->nullable()->after('promo_features');
            $table->dateTime('promo_end_at')->nullable()->after('promo_start_at');
        });

        Schema::table('subscription_sub_tiers', function (Blueprint $table) {
            $table->boolean('is_promotional')->default(false)->after('description');
            $table->string('promo_tab_title')->nullable()->after('is_promotional');
            $table->string('promo_badge')->nullable()->after('promo_tab_title');
            $table->text('promo_features')->nullable()->after('promo_badge');
            $table->dateTime('promo_start_at')->nullable()->after('promo_features');
            $table->dateTime('promo_end_at')->nullable()->after('promo_start_at');
        });

        Schema::table('subscription_sub_tiers_pendings', function (Blueprint $table) {
            $table->boolean('is_promotional')->default(false)->after('description');
            $table->string('promo_tab_title')->nullable()->after('is_promotional');
            $table->string('promo_badge')->nullable()->after('promo_tab_title');
            $table->text('promo_features')->nullable()->after('promo_badge');
            $table->dateTime('promo_start_at')->nullable()->after('promo_features');
            $table->dateTime('promo_end_at')->nullable()->after('promo_start_at');
        });
    }

    public function down(): void
    {
        $columns = [
            'is_promotional',
            'promo_tab_title',
            'promo_badge',
            'promo_features',
            'promo_start_at',
            'promo_end_at',
        ];

        Schema::table('subscription_tiers', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });

        Schema::table('subscription_tiers_pendings', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });

        Schema::table('subscription_sub_tiers', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });

        Schema::table('subscription_sub_tiers_pendings', function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};

