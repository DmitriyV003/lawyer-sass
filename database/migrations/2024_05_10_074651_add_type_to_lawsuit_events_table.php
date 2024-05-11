<?php

use App\Models\LawsuitEvent;
use App\Models\TaskTag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
//        Schema::table('lawsuit_events', function (Blueprint $table) {
//            $table->string('type')->after('theme');
//            $table->foreignIdFor(LawsuitEvent::class)
//                ->after('user_id')
//                ->nullable()
//                ->references('id')
//                ->on('lawsuit_events');
//            $table->foreignIdFor(TaskTag::class)
//                ->after('user_id')
//                ->nullable()
//                ->references('id')
//                ->on('task_tags');
//        });
    }

    public function down(): void
    {
//        Schema::table('lawsuit_events', function (Blueprint $table) {
//            $table->dropColumn('type');
//            $table->dropForeign(['lawsuit_event_id']);
//            $table->dropForeign(['task_tag_id']);
//            $table->dropColumn('lawsuit_event_id');
//            $table->dropColumn('task_tag_id');
//        });
    }
};
