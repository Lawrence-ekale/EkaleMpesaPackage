<?php

namespace Ekale\LaravelMpesa\Models;

use Illuminate\Database\Eloquent\Model;

class EkaleMpesa extends Model
{
    protected $table = 'ekale_mpesa_transactions';
    protected $fillable = [
        'id',
        'transaction_id',
        'is_confirmed',
        'created_at',
        'updated_at',
        'phone',
        'amount',
        'reference'
    ];
}