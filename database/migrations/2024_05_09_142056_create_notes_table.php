<?php

use App\Models\Customer;
use App\Models\Lawsuit;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->foreignIdFor(Lawsuit::class)->nullable()->references('id')->on('lawsuits');
            $table->foreignIdFor(Customer::class)->nullable()->references('id')->on('customers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
