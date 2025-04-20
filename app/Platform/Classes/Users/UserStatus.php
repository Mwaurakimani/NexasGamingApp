<?php

    namespace App\Platform\Classes\Users;

    enum UserStatus: int {
        case Inactive = 0;
        case Active = 1;
        case Suspended = 2;

        public function label(): string
        {
            return match ($this) {
                self::Inactive => 'Inactive',
                self::Active => 'Active',
                self::Suspended => 'Suspended',
            };
        }
    }
