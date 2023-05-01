<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientAddressResource extends JsonResource
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
            'type' => $this->type, 
            'client_id' => $this->client_id, 
            'title' => $this->title, 
            'first_name' => $this->first_name, 
            'last_name' => $this->last_name, 
            'company' => $this->company, 
            'addres1' => $this->addres1, 
            'address2' => $this->address2, 
            'city' => $this->city, 
            'post_code' => $this->post_code, 
            'state' => $this->state, 
            'country' => $this->country, 
            'phone' => $this->phone, 
            'fax' => $this->fax,
        ];
    }
}
