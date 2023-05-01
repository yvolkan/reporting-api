<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantTransaction extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id', 'merchant_id', 'referenceNo', 'status', 'operation', 'errorCode',
        'channel', 'customData', 'chain_id', 'agent_info_id', 'fx_transaction_id', 'code', 'message', 'agent'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customData' => 'object',
        'agent' => 'object'
    ];
}
