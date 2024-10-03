<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public static function set(string $key, mixed $value): self
    {
        $value = is_array($value) ? json_encode($value) : $value;

        return static::updateOrCreate(
            ['key' => $key],
            ['key' => $key, 'value' => $value],
        );
    }

    public static function setForNew(string $key, mixed $value): self
    {
        $value = is_array($value) ? json_encode($value) : $value;

        return static::firstOrCreate(
            ['key' => $key],
            ['key' => $key, 'value' => $value],
        );
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return setting($key, $default);
    }

    public static function forget(string $key): mixed
    {
        return setting()->forget($key);
    }

    public static function clearCache(): bool
    {
        return Cache::forget(config('setting.cache.key'));
    }
}
