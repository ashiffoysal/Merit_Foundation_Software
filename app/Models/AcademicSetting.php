<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Simple key/value settings for the academic module (e.g. report edit rules). */
class AcademicSetting extends Model
{
    protected $fillable = ['key', 'value'];

    private static array $cache = [];

    public static function get(string $key, $default = null)
    {
        if (! array_key_exists($key, self::$cache)) {
            self::$cache[$key] = static::where('key', $key)->value('value');
        }

        return self::$cache[$key] ?? $default;
    }

    public static function put(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        self::$cache[$key] = $value;
    }

    public static function flushCache(): void
    {
        self::$cache = [];
    }
}
