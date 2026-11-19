<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * php artisan db:seed --class=AcademicLookupSeeder
 * Safe to run more than once (uses updateOrInsert on name).
 */
class AcademicLookupSeeder extends Seeder
{
    public function run(): void
    {
        $sets = [
            'branches' => ['Forest Gate', 'Ilford', 'Plaistow', 'Online', 'Test Branch', 'ONLINE UK', 'Merit Education Foundation', 'GOODMAYES (UPCOMING)'],
            'subjects' => ['Maths', 'English', 'Science', 'Physics', 'Chemistry', 'Biology', '11+ Verbal Reasoning', '11+ Non-Verbal Reasoning', 'Arabic', 'Quran'],
            'levels'   => ['KS1', 'KS2', 'KS3', 'GCSE Foundation', 'GCSE Higher', 'A-Level', '11+'],
            'year_groups' => array_merge(['Reception'], array_map(fn ($i) => "Year {$i}", range(1, 13))),
        ];

        foreach ($sets as $table => $names) {
            foreach ($names as $i => $name) {
                DB::table($table)->updateOrInsert(['name' => $name], ['sort_order' => $i + 1, 'is_active' => true, 'updated_at' => now(), 'created_at' => now()]);
            }
        }

        $statuses = [
            ['Onboarding', 'info'], ['Assessment Booked', 'primary'], ['Active', 'success'],
            ['On Hold', 'warning'], ['Waiting List', 'secondary'], ['Left', 'dark'],
        ];
        foreach ($statuses as $i => [$name, $color]) {
            DB::table('student_statuses')->updateOrInsert(['name' => $name], ['color' => $color, 'sort_order' => $i + 1, 'is_active' => true, 'updated_at' => now(), 'created_at' => now()]);
        }
    }
}
