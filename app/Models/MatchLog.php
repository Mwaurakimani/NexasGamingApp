<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function match()
    {
        return $this->belongsTo(Matches::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
