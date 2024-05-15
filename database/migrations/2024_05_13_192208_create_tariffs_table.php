<?php

use App\Models\Tariff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cost');
            $table->string('status');
            $table->string('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Tariff::class)->nullable()->references('id')->on('tariffs');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tariff_id']);
            $table->dropColumn('tariff_id');
        });
        Schema::dropIfExists('tariffs');
    }
};
