<?php

use App\Models\LawsuitCategory;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lawsuits', function (Blueprint $table) {
            $table->id();
            $table->text('plot');
            $table->string('opponent');
            $table->integer('rating');
            $table->string('contract_number')->nullable();
            $table->dateTime('contract_signing_date')->nullable();
            $table->dateTime('contract_validity')->nullable();
            $table->string('power_of_attorney')->nullable();
            $table->dateTime('power_of_attorney_signing_date')->nullable();
            $table->dateTime('power_of_attorney_validity')->nullable();
            $table->foreignIdFor(Customer::class)->nullable();
            $table->foreignIdFor(LawsuitCategory::class);
            $table->foreignIdFor(User::class);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lawsuits');
    }
};
