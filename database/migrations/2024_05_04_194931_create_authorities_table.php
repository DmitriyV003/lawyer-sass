<?php

use App\Models\Lawsuit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorities', function (Blueprint $table) {
            $table->id();
            $table->string('lawsuit_number');
            $table->text('lawsuit_number_link')->nullable();
            $table->text('authority');
            $table->string('judge');
            $table->string('cabinet');
            $table->text('comment')->nullable();
            $table->foreignIdFor(Lawsuit::class)->references('id')->on('lawsuits');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorities');
    }
};
