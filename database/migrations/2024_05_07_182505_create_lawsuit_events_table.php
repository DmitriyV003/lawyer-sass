<?php

use App\Models\Customer;
use App\Models\Lawsuit;
use App\Models\LawsuitEventCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lawsuit_events', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->boolean('is_important')->default(false);
            $table->dateTime('since');
            $table->dateTime('till')->nullable();
            $table->unsignedBigInteger('cost')->nullable();
            $table->text('place');
            $table->text('comment')->nullable();
            $table->string('status')->default('planned');
            $table->foreignIdFor(LawsuitEventCategory::class)->references('id')->on('lawsuit_event_categories');
            $table->foreignIdFor(Customer::class)->nullable()->references('id')->on('customers');
            $table->foreignIdFor(Lawsuit::class)->nullable()->references('id')->on('lawsuits');
            $table->foreignIdFor(User::class)->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lawsuit_events');
    }
};
