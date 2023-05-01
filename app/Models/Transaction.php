<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id', 'client_id', 'client_card_id', 'client_billing_address_id', 'client_shipping_address_id',
        'merchant_id', 'acquirer_id', 'merchant_transaction_id', 'originalAmount', 'originalCurreny', 'ipn', 'refundable'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'ipn' => 'array',
        'refundable' => 'boolean'
    ];

    /**
     * Get the client card.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the client card.
     */
    public function card()
    {
        return $this->belongsTo(ClientCard::class, 'client_card_id', 'id');
    }

    /**
     * Get the client billing address.
     */
    public function billing_address()
    {
        return $this->belongsTo(ClientAddress::class, 'client_billing_address_id', 'id');
    }
    
    /**
     * Get the client shipping address.
     */
    public function shipping_address()
    {
        return $this->belongsTo(ClientAddress::class, 'client_shipping_address_id', 'id');
    }

    /**
     * Get the merchant.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the transaction merchant.
     */
    public function merchantTransaction()
    {
        return $this->belongsTo(MerchantTransaction::class);
    }

    /**
     * Get the acquirer.
     */
    public function acquirer()
    {
        return $this->belongsTo(Acquire::class);
    }
}
