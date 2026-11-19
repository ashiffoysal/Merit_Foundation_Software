<?php

return [
    /*
     | Lesson start times are local "wall clock" times. This timezone is used to work out
     | which class is live now, today's classes and the next upcoming class.
     */
    'timezone' => env('ACADEMIC_TIMEZONE', 'Europe/London'),

    // how many days back the teacher dashboard looks for classes without a report
    'pending_report_days' => (int) env('ACADEMIC_PENDING_REPORT_DAYS', 14),
];
