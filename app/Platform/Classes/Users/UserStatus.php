<?php

    namespace App\Platform\Classes\Users;

    enum UserStatus: int {
        case Inactive = 0;
        case Active = 1;
        case Suspended = 2;

        public static function fromLabel(string $label): self
        {
            return match ($label) {
                'Inactive' => self::Inactive,
                'Active' => self::Active,
                'Suspended' => self::Suspended,
                default => self::Inactive,
            };
        }

        public function label(): string
        {
            return match ($this) {
                self::Inactive => 'Inactive',
                self::Active => 'Active',
                self::Suspended => 'Suspended',
            };
        }

        public static function tryFromName(string $name): ?self
        {
            return collect(self::cases())->first(fn ($case) => strtolower($case->name) === strtolower($name));
        }
    }
