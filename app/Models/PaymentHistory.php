<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'pajak_id',
        'order_id',
        'snap_token',
        'amount',
        'status',
    ];

    public function pajak()
    {
        return $this->belongsTo(PajakKendaraan::class, 'pajak_id');
    }
}
