<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Matches extends Model {
        public $incrementing = false;       // ✅ UUIDs are not auto-increment
        protected $keyType = 'string';      // ✅ UUID is a string

        protected $table = 'matches';
        protected $guarded = [];

        public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Game::class);
        }

        public function matchType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(MatchType::class);
        }

        public function participants(): HasMany
        {
            return $this->hasMany(MatchParticipant::class, 'match_id', 'id');
        }

        public function logs(): HasMany
        {
            return $this->hasMany(MatchLog::class);
        }

        public function winner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(User::class, 'winner_id');
        }
    }
