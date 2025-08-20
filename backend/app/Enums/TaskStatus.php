<?php

namespace App\Enums;

use \Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self completed()
 */
final class TaskStatus extends Enum
{
    public static function pending(): self
    {
        return new self(1);
    }

    public static function completed(): self
    {
        return new self(2);
    }

    protected static function values(): array
    {
        return [
            'pending' => 1,
            'completed' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'pending' => "Pending",
            'completed' => "Completed",
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
