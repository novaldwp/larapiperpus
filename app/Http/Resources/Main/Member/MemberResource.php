<?php

namespace App\Http\Resources\Main\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'id'            => $this->id,
            'code'          => $this->code,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'bop'           => $this->bop,
            'bod'           => $this->bod,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'gender_id'     => $this->gender_id,
            'created_at'    => $this->created_at->format('d-m-Y'),
            'updated_at'    => $this->updated_at->format('d-m-Y')
        ];
    }
}
