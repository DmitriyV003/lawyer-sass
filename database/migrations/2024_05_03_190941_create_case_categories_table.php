<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lawsuit_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->foreignIdFor(User::class);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['user_id', 'name', 'color']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lawsuit_categories');
    }
};
