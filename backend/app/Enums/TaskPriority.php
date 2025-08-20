<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self low()
 * @method static self medium()
 * @method static self high()
 */
final class TaskPriority extends Enum
{
    public static function low(): self
    {
        return new self(1);
    }

    public static function medium(): self
    {
        return new self(2);
    }

    public static function high(): self
    {
        return new self(3);
    }

    protected static function values(): array
    {
        return [
            'low' => 1,
            'medium' => 2,
            'high' => 3
        ];
    }

    protected static function labels(): array
    {
        return [
            'low' => "Low",
            'medium' => "Medium",
            'high' => "High"
        ];
    }

    public static function getValues(): array
    {
        return array_values(static::values());
    }

    public static function getLabels(): array
    {
        return array_values(static::labels());
    }
}
