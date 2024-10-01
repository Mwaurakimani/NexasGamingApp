<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matches extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['moderator_id', 'mode', 'date', 'teams', 'status', 'time', 'stake', 'link', 'password', 'pace', 'notes',];

    protected $appends = [
        'moderator_data',
    ];

    public function moderator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id', 'id');
    }

    public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participants::class, 'match_id', "id");
    }

    public function players()
    {
        // 'participants' is the pivot table, 'match_id' and 'user_id' are foreign keys
        return $this->belongsToMany(User::class, 'participants', 'match_id', 'user_id')
            ->withPivot( 'grouped', 'grouped_name', 'user_score', 'moderator_score', 'status', 'payout', 'results',)
            ->withTimestamps()
        ;
    }

    public function getModeratorDataAttribute()
    {
        return $this->moderator ? $this->moderator->username : null;
    }


}
