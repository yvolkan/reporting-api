<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $transactionClient = new TransactionClientResource($this);

        return [
            'fx' => [
                'merchant' => [
                    'originalAmount' => $this->originalAmount,
                    'originalCurreny' => $this->originalCurreny,
                ],
            ],
            'customerInfo' => $transactionClient,
            'merchant' => new MerchantResource($this->merchant),
            'ipn' => $this->ipn,
            'transaction' => [
                'merchant' => new MerchantTransactionResource($this->merchantTransaction),
            ],
            'acquirer' => new AcquireResource($this->acquirer),
            'refundable' => $this->refundable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
