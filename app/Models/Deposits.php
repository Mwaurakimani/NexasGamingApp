<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposits extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id','processed_by','phone_number', 'amount','transaction_code', 'status', 'notes'];
}
