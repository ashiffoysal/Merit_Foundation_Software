<?php

namespace App\Services\Academic;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

/** Writes the teacher employment history and the student registration history. */
class HistoryRecorder
{
    private function adminId(): ?int
    {
        return Auth::guard('admin')->id();
    }

    public function teacherCreated(Teacher $t): void
    {
        $t->histories()->create([
            'event' => 'joined', 'description' => 'Teacher record created' . ($t->job_title ? " as {$t->job_title}" : ''),
            'new_value' => $t->branch?->name, 'effective_date' => $t->joining_date ?? now(), 'admin_id' => $this->adminId(),
        ]);
    }

    /** $before = attribute snapshot taken before the update */
    public function teacherUpdated(Teacher $t, array $before, ?string $branchBefore): void
    {
        $tracked = [
            'job_title'        => ['job_title_changed', 'Job title changed'],
            'hourly_rate'      => ['rate_changed', 'Hourly rate changed'],
            'joining_date'     => ['joining_date_changed', 'Joining date changed'],
            'resignation_date' => ['resigned', 'Resignation date set'],
            'is_active'        => ['status_changed', 'Employment status changed'],
            'has_dbs'          => ['dbs_changed', 'DBS status changed'],
        ];

        $branchAfter = $t->branch?->name;
        if ($branchBefore !== $branchAfter) {
            $this->teacherEvent($t, 'branch_changed', 'Branch changed', $branchBefore, $branchAfter);
        }

        foreach ($tracked as $field => [$event, $label]) {
            $old = $this->scalar($before[$field] ?? null);
            $new = $this->scalar($t->getAttribute($field));
            if ($old === $new) {
                continue;
            }
            if ($field === 'resignation_date' && $new === null) {
                [$event, $label] = ['resignation_cleared', 'Resignation date removed'];
            }
            if (in_array($field, ['is_active', 'has_dbs'], true)) {
                [$old, $new] = [$old === null ? null : ($old ? 'Yes' : 'No'), $new ? 'Yes' : 'No'];
            }
            $effective = $field === 'resignation_date' ? $t->resignation_date : now();
            $this->teacherEvent($t, $event, $label, $old, $new, $effective);
        }
    }

    public function teacherEvent(Teacher $t, string $event, string $description, $old = null, $new = null, $date = null): void
    {
        $t->histories()->create([
            'event' => $event, 'description' => $description,
            'old_value' => $old, 'new_value' => $new,
            'effective_date' => $date ?? now(), 'admin_id' => $this->adminId(),
        ]);
    }

    public function student(Student $s, string $event, string $description, ?array $changes = null): void
    {
        $s->histories()->create([
            'event' => $event, 'description' => $description, 'changes' => $changes, 'admin_id' => $this->adminId(),
        ]);
    }

    /** Compare two snapshots and log one "updated" row with the field-level diff */
    public function studentUpdated(Student $s, array $before, array $after): void
    {
        $diff = [];
        foreach ($after as $key => $value) {
            $old = $this->scalar($before[$key] ?? null);
            $new = $this->scalar($value);
            if ($old !== $new) {
                $diff[$key] = ['from' => $old, 'to' => $new];
            }
        }
        if (! $diff) {
            return;
        }

        $event = isset($diff['status']) ? 'status_changed' : 'updated';
        $desc  = isset($diff['status'])
            ? 'Status changed from ' . ($diff['status']['from'] ?? '—') . ' to ' . ($diff['status']['to'] ?? '—')
            : 'Student details updated (' . implode(', ', array_map(fn ($k) => str_replace('_', ' ', $k), array_keys($diff))) . ')';

        $this->student($s, $event, $desc, $diff);
    }

    private function scalar($v)
    {
        if ($v instanceof \DateTimeInterface) {
            return $v->format('Y-m-d');
        }
        if (is_bool($v)) {
            return $v;
        }
        if (is_numeric($v) && ! is_int($v)) {
            return number_format((float) $v, 2, '.', '');
        }
        return $v === '' ? null : $v;
    }
}
