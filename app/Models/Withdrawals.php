<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawals extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['user_id','moderator_status', 'processed_by','phone_number', 'amount', 'transaction_code', 'status', 'notes'];

}