<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'addon_id',
        'addon_name',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}