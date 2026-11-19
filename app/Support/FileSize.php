<?php

namespace App\Support;

/** Human-readable file sizes without needing the PHP "intl" extension (Laravel's Number::fileSize needs it). */
class FileSize
{
    public static function human(int|float|null $bytes, int $precision = 1): string
    {
        $bytes = max(0, (float) $bytes);
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return ($i === 0 ? (int) $bytes : round($bytes, $precision)) . ' ' . $units[$i];
    }
}
