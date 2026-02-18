<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    protected $table = 'app.transactions';

    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'branch_id',
        'division_id',
        'region_code',
        'amount',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];
}
