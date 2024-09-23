<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->hasMany(Participants::class, 'match_id',"id");
    }

    public function getModeratorDataAttribute()
    {
        return $this->moderator ? $this->moderator->username : null;
    }


}
