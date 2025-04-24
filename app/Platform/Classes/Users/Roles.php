<?php

    namespace App\Platform\Classes\Users;

    enum Roles: string
    {
        case User = 'Guest';
        case Player = 'Player';
        case Moderator = 'Moderator';
        case Manager = 'Manager';
        case Admin = 'Admin';
        case SuperAdmin = 'Super Admin';

        public static function tryFromName(string $name): ?self
        {
            return collect(self::cases())
                ->first(fn ($case) => strtolower($case->name) === strtolower($name));
        }

        public static function values(): array
        {
            return array_column(self::cases(), 'value');
        }

        public static function options(): array
        {
            return collect(self::cases())->mapWithKeys(fn ($role) => [
                $role->value => $role->label()
            ])->toArray();
        }

        public function label(): string
        {
            return match ($this) {
                self::User        => 'Basic User',
                self::Player      => 'Player',
                self::Moderator   => 'Moderator',
                self::Manager     => 'Manager',
                self::Admin       => 'Admin',
                self::SuperAdmin  => 'Super Administrator',
            };
        }
    }
