<?php

namespace App\Http\Controllers\Backend\Academic;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\Academic\Concerns\RespondsToAjax;
use App\Models\AcademicSetting;
use App\Services\Academic\ReportEditPolicy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportSettingsController extends Controller
{
    use RespondsToAjax;

    public function edit(ReportEditPolicy $policy)
    {
        return view('backend.academic.settings.reports', ['mode' => $policy->mode(), 'days' => $policy->days(), 'modes' => ReportEditPolicy::MODES]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'report_edit_mode' => ['required', Rule::in(array_keys(ReportEditPolicy::MODES))],
            'report_edit_days' => 'required_if:report_edit_mode,within_days|nullable|integer|min:1|max:365',
        ]);

        AcademicSetting::put('report_edit_mode', $data['report_edit_mode']);
        if (! empty($data['report_edit_days'])) {
            AcademicSetting::put('report_edit_days', (string) $data['report_edit_days']);
        }

        return $this->done($request, 'Report settings saved.', route('admin.report-settings.edit'));
    }
}
