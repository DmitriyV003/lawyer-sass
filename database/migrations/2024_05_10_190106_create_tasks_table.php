<?php

use App\Models\Customer;
use App\Models\Lawsuit;
use App\Models\LawsuitEvent;
use App\Models\Task;
use App\Models\TaskTag;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('theme');
            $table->boolean('is_important')->nullable();
            $table->dateTime('deadline');
            $table->bigInteger('cost')->nullable();
            $table->text('comment')->nullable();
            $table->string('status')->default('planned');
            $table->timestamp('to_do_date')->nullable();
            $table->foreignIdFor(Customer::class)->nullable()->references('id')->on('customers');
            $table->foreignIdFor(Lawsuit::class)->nullable()->references('id')->on('lawsuits');
            $table->foreignIdFor(TaskTag::class)->references('id')->on('task_tags');
            $table->foreignIdFor(User::class)->references('id')->on('users');
            $table->timestamps();

            $table->index(['to_do_date']);
        });

        Schema::table('lawsuit_events', function (Blueprint $table) {
            $table->foreignIdFor(Task::class)
                ->after('user_id')
                ->nullable()
                ->references('id')
                ->on('tasks');
        });

        Schema::table('notes', function (Blueprint $table) {
            $table->foreignIdFor(LawsuitEvent::class)
                ->nullable()
                ->references('id')
                ->on('lawsuit_events');
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['lawsuit_event_id']);
            $table->dropColumn('lawsuit_event_id');
        });
        Schema::table('lawsuit_events', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
            $table->dropColumn('task_id');
        });
        Schema::dropIfExists('tasks');
    }
};
