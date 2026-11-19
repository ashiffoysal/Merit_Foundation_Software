<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_sessions', function (Blueprint $table) {
            $table->string('completion_status', 30)->default('completed')->after('status')->index(); // completed | partially_completed | not_completed
            $table->text('topics_covered')->nullable()->after('topic');
            $table->foreignId('level_id')->nullable()->after('teacher_id')->constrained('levels')->nullOnDelete();
            $table->foreignId('subject_id')->nullable()->after('level_id')->constrained('subjects')->nullOnDelete();
            $table->string('edit_override', 10)->nullable()->after('submitted_at'); // null = follow settings, 'allow', 'lock'
        });

        Schema::table('lesson_session_students', function (Blueprint $table) {
            $table->string('understanding', 20)->nullable()->after('progress');   // excellent | good | fair | poor
            $table->text('challenges')->nullable()->after('homework_done');
        });

        Schema::create('academic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // backfill existing class reports
        DB::table('lesson_sessions')->where('status', 'cancelled')->update(['completion_status' => 'not_completed']);
        foreach (DB::table('lessons')->select('id', 'level_id', 'subject_id')->get() as $l) {
            DB::table('lesson_sessions')->where('lesson_id', $l->id)->update(['level_id' => $l->level_id, 'subject_id' => $l->subject_id]);
        }

        DB::table('academic_settings')->insert([
            ['key' => 'report_edit_mode', 'value' => 'within_days', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'report_edit_days', 'value' => '7', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_settings');
        Schema::table('lesson_session_students', fn (Blueprint $t) => $t->dropColumn(['understanding', 'challenges']));
        Schema::table('lesson_sessions', function (Blueprint $t) {
            $t->dropIndex(['completion_status']);
            $t->dropConstrainedForeignId('level_id');
            $t->dropConstrainedForeignId('subject_id');
            $t->dropColumn(['completion_status', 'topics_covered', 'edit_override']);
        });
    }
};
