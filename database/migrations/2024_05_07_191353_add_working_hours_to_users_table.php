<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->time('start_working_time')->default('09:00')->after('login_attempts');
            $table->time('end_working_time')->default('18:00')->after('login_attempts');
            $table->integer('working_time_interval')->default(15)->after('login_attempts');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('start_working_time');
            $table->dropColumn('end_working_time');
            $table->dropColumn('working_time_interval');
        });
    }
};
