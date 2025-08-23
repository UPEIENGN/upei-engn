<?php

namespace App;

enum SocietyMemberRole: int
{
    case Member = 1;
    case Admin = 2;
    case Owner = 3;

    public function label(): string
    {
        return match ($this) {
            self::Member => 'Member',
            self::Admin => 'Admin',
            self::Owner => 'Owner',
        };
    }

    public static function asSelectArray(): array
    {
        return array_map(function ($case) {
            return [
                'name' => $case->label(),
                'value' => $case->value,
            ];
        }, self::cases());
    }
}
