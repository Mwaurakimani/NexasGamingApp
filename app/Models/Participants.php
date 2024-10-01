<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participants extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'match_id',
        'user_id',
        'user_score',
        'moderator_score',
        'status',
        'payout',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
