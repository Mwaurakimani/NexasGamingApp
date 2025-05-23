<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchParticipant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function match()
    {
        return $this->belongsTo(Matches::class, 'match_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
