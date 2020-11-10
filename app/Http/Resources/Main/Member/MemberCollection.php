<?php

namespace App\Http\Resources\Main\Member;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MemberCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($member) {
                return [
                    'id'            => $member->id,
                    'code'          => $member->code,
                    'first_name'    => $member->first_name,
                    'last_name'     => $member->last_name,
                    'email'         => $member->email,
                    'phone'         => $member->phone,
                    'address'       => $member->address,
                    'image'         => [
                        'thumb' => public_path('images/'.(( $member->image == "") ? "no_image.jpg":"member/thumb/".$member->image)),
                        'full'  => public_path('images/'.(( $member->image == "") ? "no_image.jpg": "member/".$member->image))
                    ]
                ];
            })
        ];
    }
}
