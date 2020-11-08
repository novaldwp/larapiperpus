<?php

namespace App\Http\Resources\Master\Publisher;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PublisherCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($publisher) {
                return [
                    'id'        => $publisher->id,
                    'name'      => $publisher->name,
                    'phone'     => $publisher->phone,
                    'address'   => $publisher->address
                ];
            }),
        ];
    }
}
