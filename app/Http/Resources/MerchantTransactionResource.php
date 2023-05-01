<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchantTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'transactionId' => $this->transaction_id,
            'referenceNo' => $this->referenceNo,
            'merchantId' => $this->merchant_id,
            'status' => $this->status,
            'channel' => $this->channel,
            'customData' => $this->customData,
            'chainId' => $this->chain_id,
            'agentInfoId' => $this->agent_info_id,
            'operation' => $this->operation,
            'fxTransactionId' => $this->fx_transaction_id,
            'code' => $this->code,
            'message' => $this->message,
            'errorCode' => $this->errorCode,
            'agent' => $this->agent,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
