<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchType extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function matches()
    {
        return $this->hasMany(Matches::class);
    }

}
