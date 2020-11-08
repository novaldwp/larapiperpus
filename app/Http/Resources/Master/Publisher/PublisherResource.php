<?php

namespace App\Http\Resources\Master\Publisher;

use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'city'      => $this->city,
            'address'   => $this->address,
            'postcode'  => $this->postcode
        ];
    }
}
