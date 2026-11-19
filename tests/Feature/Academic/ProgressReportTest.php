<?php

namespace Tests\Feature\Academic;

use App\Models\Lesson;
use App\Models\LessonSession;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;

class ProgressReportTest extends AcademicTestCase
{
    private Teacher $teacher;
    private Lesson $lesson;
    private Student $a;
    private Student $b;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(Carbon::parse('2026-11-21 12:00:00', 'Europe/London')); // Saturday, after class
        $this->teacher = Teacher::create(['first_name' => 'Ali', 'last_name' => 'Hasan', 'phone' => '07000000000', 'email' => 'ali@m.test', 'password' => 'Secret123']);
        $this->lesson = Lesson::create(['name' => 'KS2 Maths', 'teacher_id' => $this->teacher->id,
            'level_id' => $this->id('levels', 'KS2'), 'subject_id' => $this->id('subjects', 'Maths'),
            'weekday' => 0, 'start_time' => '10:00:00', 'end_time' => '11:00:00', 'duration_minutes' => 60, 'capacity' => 5, 'start_date' => '2026-10-03']);
        $this->a = Student::create(['first_name' => 'Adam', 'last_name' => 'K']);
        $this->b = Student::create(['first_name' => 'Bushra', 'last_name' => 'M']);
        $this->lesson->students()->attach([$this->a->id, $this->b->id]);
    }

    private function submit(string $date, array $students, array $over = [])
    {
        return $this->actingAs($this->teacher, 'teacher')->ajax()->put(route('teacher.reports.update', [$this->lesson, $date]), array_merge([
            'completion_status' => 'completed', 'topic' => 'Fractions', 'topics_covered' => 'Equivalent fractions', 'homework' => 'p.12', 'notes' => 'ok',
            'students' => $students,
        ], $over));
    }

    public function test_report_with_all_progress_fields(): void
    {
        $this->actingAs($this->teacher, 'teacher')->get(route('teacher.reports.edit', [$this->lesson, '2026-11-21']))->assertOk()
            ->assertSee('Lesson status *')->assertSee('Partially completed')->assertSee('Challenges / to improve')->assertSee('KS2');

        $this->submit('2026-11-21', [
            $this->a->id => ['attendance' => 'present', 'progress' => 'good', 'understanding' => 'fair', 'score' => 6, 'challenges' => 'Simplifying', 'comment' => 'Trying hard'],
            $this->b->id => ['attendance' => 'present', 'understanding' => 'bogus'],
        ], ['completion_status' => 'partially_completed'])->assertStatus(422)->assertJsonValidationErrors("students.{$this->b->id}.understanding");

        $this->submit('2026-11-21', [
            $this->a->id => ['attendance' => 'present', 'progress' => 'good', 'understanding' => 'fair', 'score' => 6, 'challenges' => 'Simplifying', 'comment' => 'Trying hard'],
            $this->b->id => ['attendance' => 'absent', 'understanding' => 'excellent'],
        ], ['completion_status' => 'partially_completed'])->assertOk();

        $s = LessonSession::firstOrFail();
        $this->assertSame('partially_completed', $s->completion_status);
        $this->assertSame('held', $s->status);
        $this->assertSame('Equivalent fractions', $s->topics_covered);
        $this->assertSame($this->id('levels', 'KS2'), $s->level_id);
        $this->assertSame($this->id('subjects', 'Maths'), $s->subject_id);
        $ra = $s->records()->where('student_id', $this->a->id)->first();
        $this->assertSame(['fair', 'Simplifying'], [$ra->understanding, $ra->challenges]);
        $this->assertNull($s->records()->where('student_id', $this->b->id)->value('understanding')); // absent

        $this->get(route('teacher.reports.show', $s))->assertOk()->assertSee('Partially completed')->assertSee('Simplifying')->assertSee('Equivalent fractions');

        // not completed = lesson didn't happen, needs reason, no attendance
        $this->submit('2026-11-14', [], ['completion_status' => 'not_completed', 'notes' => ''])->assertStatus(422)->assertJsonValidationErrors('notes');
        $this->submit('2026-11-14', [], ['completion_status' => 'not_completed', 'notes' => 'Snow day'])->assertOk();
        $this->assertSame('cancelled', LessonSession::whereDate('session_date', '2026-11-14')->value('status'));

        // history list + filters
        $this->defaultHeaders = [];
        $this->get(route('teacher.reports.index', ['completion_status' => 'not_completed']))->assertOk()->assertSee('Sat 14 Nov 2026')->assertDontSee('Sat 21 Nov 2026');
    }

    public function test_edit_rules_controlled_by_admin(): void
    {
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'present']])->assertOk();
        $s = LessonSession::first();

        // default: 7 days
        $this->travelTo(Carbon::parse('2026-11-27 12:00:00', 'Europe/London'));
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'late']])->assertOk();
        $this->travelTo(Carbon::parse('2026-11-29 12:00:00', 'Europe/London'));
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'absent']])->assertForbidden()
            ->assertJsonFragment(['message' => 'The 7-day edit window has passed. Contact the office if a change is needed.']);
        $this->defaultHeaders = [];
        $this->get(route('teacher.reports.edit', [$this->lesson, '2026-11-21']))->assertRedirect(route('teacher.reports.show', $s));
        $this->get(route('teacher.reports.show', $s))->assertSee('Locked');

        // admin allows this one report
        $this->actingAs($this->admin, 'admin')->ajax()->patch(route('admin.progress.edit-access', $s), ['edit_override' => 'allow'])->assertOk();
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'absent']])->assertOk();

        // admin locks it
        $this->actingAs($this->admin, 'admin')->ajax()->patch(route('admin.progress.edit-access', $s), ['edit_override' => 'lock'])->assertOk();
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'present']])->assertForbidden();

        // back to settings, set "always"
        $this->actingAs($this->admin, 'admin')->ajax()->patch(route('admin.progress.edit-access', $s), ['edit_override' => 'default'])->assertOk();
        $this->ajax()->put(route('admin.report-settings.update'), ['report_edit_mode' => 'within_days', 'report_edit_days' => ''])->assertStatus(422);
        $this->ajax()->put(route('admin.report-settings.update'), ['report_edit_mode' => 'always'])->assertOk();
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'present']])->assertOk();

        // "never": first submission still fine, edits blocked
        $this->actingAs($this->admin, 'admin')->ajax()->put(route('admin.report-settings.update'), ['report_edit_mode' => 'never'])->assertOk();
        $this->submit('2026-11-28', [$this->a->id => ['attendance' => 'present']])->assertOk();
        $this->submit('2026-11-28', [$this->a->id => ['attendance' => 'late']])->assertForbidden();

        $this->defaultHeaders = [];
        $this->actingAs($this->admin, 'admin')->get(route('admin.report-settings.edit'))->assertOk()->assertSee('Teachers cannot edit after submitting');
        $this->get(route('admin.lessons.report', $s))->assertOk()->assertSee('Follows report settings')->assertSee('Allow editing');
    }

    public function test_teacher_cannot_report_for_unauthorised_lessons_or_students(): void
    {
        $other = Teacher::create(['first_name' => 'Z', 'last_name' => 'Q', 'phone' => '07000000001', 'email' => 'z@m.test', 'password' => 'x']);
        $this->actingAs($other, 'teacher')->ajax()->put(route('teacher.reports.update', [$this->lesson, '2026-11-21']), ['completion_status' => 'completed', 'topic' => 'x'])->assertNotFound();

        $stranger = Student::create(['first_name' => 'S', 'last_name' => 'X']);
        $this->submit('2026-11-21', [$stranger->id => ['attendance' => 'present']])->assertStatus(422);
    }

    public function test_admin_progress_page_filters_stats_and_support(): void
    {
        // Adam struggles: two weak reports + low scores; Bushra fine
        $this->submit('2026-11-07', [$this->a->id => ['attendance' => 'present', 'progress' => 'needs_improvement', 'score' => 3], $this->b->id => ['attendance' => 'present', 'progress' => 'excellent', 'score' => 9]]);
        $this->submit('2026-11-14', [$this->a->id => ['attendance' => 'present', 'understanding' => 'poor', 'score' => 4], $this->b->id => ['attendance' => 'present', 'progress' => 'good', 'score' => 8]], ['completion_status' => 'partially_completed']);
        $this->submit('2026-11-21', [], ['completion_status' => 'not_completed', 'notes' => 'Closed']);

        $this->defaultHeaders = [];
        $this->actingAs($this->admin, 'admin');
        $page = $this->get(route('admin.progress.index'))->assertOk()->assertSee('May need support')->assertSee('Adam K')->assertSee('2 weak report(s)');
        $support = $page->viewData('support');
        $this->assertSame([$this->a->id], $support->pluck('student.id')->all());

        $stats = $page->viewData('stats');
        $this->assertSame(3, $stats['sessions']);
        $this->assertEquals(1, $stats['completion']['partially_completed']);
        $this->assertEquals(1, $stats['completion']['not_completed']);
        $this->assertSame(4, $stats['reports']);
        $this->assertSame(6.0, $stats['avg_score']);
        $this->assertSame(100, $stats['attendance']);

        $h = ['X-Requested-With' => 'XMLHttpRequest'];
        $rows = fn (array $q) => $this->get(route('admin.progress.index', $q), $h)->assertOk();
        $rows(['student_id' => $this->b->id])->assertSee('Bushra M')->assertDontSee('Adam K');
        $rows(['teacher_id' => $this->teacher->id, 'level_id' => $this->id('levels', 'KS2'), 'subject_id' => $this->id('subjects', 'Maths')])->assertSee('Adam K');
        $rows(['subject_id' => $this->id('subjects', 'English')])->assertSee('No reports match');
        $rows(['from' => '2026-11-10', 'to' => '2026-11-15'])->assertSee('14 Nov 2026')->assertDontSee('07 Nov 2026');
        $rows(['progress' => 'needs_improvement'])->assertSee('Adam K')->assertDontSee('Bushra M');
        $rows(['completion_status' => 'partially_completed'])->assertSee('14 Nov 2026')->assertDontSee('07 Nov 2026');

        // student profile + lesson page show it too
        $this->get(route('admin.students.show', $this->a))->assertOk()->assertSee('Needs improvement');
    }

    /** MySQL ONLY_FULL_GROUP_BY: aggregate queries must not also select plain columns (SQLite doesn't catch this) */
    public function test_aggregate_queries_are_mysql_strict_safe(): void
    {
        $this->submit('2026-11-21', [$this->a->id => ['attendance' => 'present', 'score' => 7]]);
        $this->defaultHeaders = [];

        $sql = [];
        \DB::listen(function ($q) use (&$sql) { $sql[] = $q->sql; });
        $this->actingAs($this->admin, 'admin')->get(route('admin.progress.index'))->assertOk();

        $aggregates = array_filter($sql, fn ($s) => preg_match('/\b(count|avg|sum)\(/i', $s) && ! str_contains($s, 'group by') && ! str_contains($s, 'exists') && ! str_contains($s, ' as aggregate'));
        $this->assertNotEmpty($aggregates);
        foreach ($aggregates as $s) {
            $this->assertStringNotContainsString('lesson_session_students".*', $s, "Aggregate query also selects plain columns: {$s}");
        }
    }
}
