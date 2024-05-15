<?php

use App\Models\Permission;
use App\Models\Tariff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tariff_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tariff::class)->references('id')->on('tariffs');
            $table->foreignIdFor(Permission::class)->references('id')->on('permissions');

            $table->unique(['tariff_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariff_permission');
    }
};
