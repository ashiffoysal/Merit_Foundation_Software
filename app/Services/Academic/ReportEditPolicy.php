<?php

namespace App\Services\Academic;

use App\Models\AcademicSetting;
use App\Models\LessonSession;

/**
 * Decides whether a teacher may still edit a submitted report.
 * Admin controls it globally (Report Settings) and can override one report (allow / lock).
 */
class ReportEditPolicy
{
    public const MODES = [
        'always'      => 'Teachers can always edit their reports',
        'within_days' => 'Teachers can edit for a number of days after submitting',
        'never'       => 'Teachers cannot edit after submitting',
    ];

    public function mode(): string
    {
        $mode = AcademicSetting::get('report_edit_mode', 'within_days');

        return array_key_exists($mode, self::MODES) ? $mode : 'within_days';
    }

    public function days(): int
    {
        return max(0, (int) AcademicSetting::get('report_edit_days', 7));
    }

    public function teacherCanEdit(LessonSession $session): bool
    {
        if (! $session->exists) {
            return true; // first submission is always allowed
        }

        return match ($session->edit_override) {
            'allow' => true,
            'lock'  => false,
            default => match ($this->mode()) {
                'always' => true,
                'never'  => false,
                default  => ($session->submitted_at ?? $session->created_at)->copy()->addDays($this->days())->isFuture(),
            },
        };
    }

    /** Short text for the teacher UI */
    public function explain(LessonSession $session): string
    {
        if ($session->edit_override === 'lock') {
            return 'This report has been locked by the office.';
        }
        if ($session->edit_override === 'allow') {
            return 'The office has allowed you to edit this report.';
        }

        return match ($this->mode()) {
            'always' => 'You can edit this report.',
            'never'  => 'Reports cannot be edited after submission. Contact the office if a change is needed.',
            default  => $this->teacherCanEdit($session)
                ? 'You can edit until ' . ($session->submitted_at ?? $session->created_at)->copy()->addDays($this->days())->format('d M Y H:i') . '.'
                : 'The ' . $this->days() . '-day edit window has passed. Contact the office if a change is needed.',
        };
    }
}
