<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Laravel\Sanctum\HasApiTokens;
    use Laravel\Jetstream\HasProfilePhoto;
    use Illuminate\Notifications\Notifiable;
    use App\Platform\Classes\Users\UserStatus;
    use Laravel\Fortify\TwoFactorAuthenticatable;
    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable {
        use HasApiTokens;
        use HasFactory;
        use HasProfilePhoto;
        use Notifiable;
        use TwoFactorAuthenticatable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'username',
            'email',
            'phone_number',
            'balance',
            'email_verified_at',
            'password',
            'role',
            'is_active'
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ];

        /**
         * The accessors to append to the model's array form.
         *
         * @var array<int, string>
         */
        protected $appends = [
            'profile_photo_url',
        ];

        /**
         * Get the attributes that should be cast.
         *
         * @return array<string, string>
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];

        public function matches()
        {
            return $this
                ->belongsToMany(Matches::class, 'participants', 'user_id', 'match_id')
                ->withPivot('grouped', 'grouped_name', 'user_score', 'moderator_score', 'status', 'payout', 'results')
                ->withTimestamps();
        }

        protected function isActive(): Attribute
        {
            return Attribute::make(
                get: fn($value) => UserStatus::from($value)->label(),
                set: fn($value) => UserStatus::fromLabel($value)->value
            );
        }

        public function hasRole(string $roles): bool
        {
            $allowed = explode('|', $roles);
            return in_array($this->role, $allowed, true);
        }

    }
