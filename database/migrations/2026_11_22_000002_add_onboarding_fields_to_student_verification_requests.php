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
        Schema::table('student_verification_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('student_verification_requests', 'faculty_department')) {
                $table->string('faculty_department')->nullable()->after('institution_name');
            }
            if (!Schema::hasColumn('student_verification_requests', 'role_within_institution')) {
                $table->string('role_within_institution', 100)->nullable()->after('faculty_department');
            }
            if (!Schema::hasColumn('student_verification_requests', 'institutional_email')) {
                $table->string('institutional_email')->nullable()->after('role_within_institution');
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
        Schema::table('student_verification_requests', function (Blueprint $table) {
            if (Schema::hasColumn('student_verification_requests', 'institutional_email')) {
                $table->dropColumn('institutional_email');
            }
            if (Schema::hasColumn('student_verification_requests', 'role_within_institution')) {
                $table->dropColumn('role_within_institution');
            }
            if (Schema::hasColumn('student_verification_requests', 'faculty_department')) {
                $table->dropColumn('faculty_department');
            }
        });
    }
};

