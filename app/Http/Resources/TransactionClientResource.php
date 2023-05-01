<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $client = new ClientResource($this->client);
        $client_card = new ClientCardResource($this->card);
        $client_billing = new ClientAddressResource($this->billing_address);
        $client_shipping = new ClientAddressResource($this->shipping_address);

        return [
            'id' => $client->id,
            'email' => $client->email,
            'birthday' => $client->birthday,
            'gender' => $client->gender,

            'number' => $client_card->number,
            'expiryMonth' => $client_card->expiryMonth,
            'expiryYear' => $client_card->expiryYear,
            'startMonth' => $client_card->startMonth,
            'startYear' => $client_card->startYear,
            'issueNumber' => $client_card->issueNumber,

            'billingFirstName' => $client_billing->first_name,
            'billingLastName' => $client_billing->last_name,
            'billingCompany' => $client_billing->company,
            'billingAddress1' => $client_billing->address1,
            'billingAddress2' => $client_billing->address2,
            'billingCity' => $client_billing->city,
            'billingPostcode' => $client_billing->post_code,
            'billingState' => $client_billing->state,
            'billingCountry' => $client_billing->country,
            'billingPhone' => $client_billing->phone,
            'billingFax' => $client_billing->fax,

            'shippingFirstName' => $client_shipping->first_name,
            'shippingLastName' => $client_shipping->last_name,
            'shippingCompany' => $client_shipping->company,
            'shippingAddress1' => $client_shipping->address1,
            'shippingAddress2' => $client_shipping->address2,
            'shippingCity' => $client_shipping->city,
            'shippingPostcode' => $client_shipping->post_code,
            'shippingState' => $client_shipping->state,
            'shippingCountry' => $client_shipping->country,
            'shippingPhone' => $client_shipping->phone,
            'shippingFax' => $client_shipping->fax,

            'created_at' => $client->created_at,
            'updated_at' => $client->updated_at,
            'deleted_at' => $client->deleted_at,
        ];
    }
}
