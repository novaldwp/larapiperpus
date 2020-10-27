<?php

namespace App\Http\Resources\Transaction\TReturn;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReturnCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($treturn){
                return [
                    'id'        => $treturn->id,
                    'code'      => $treturn->loan->code,
                    'title'     => $treturn->loan->book->title,
                    'late'      => $treturn->late_day. ' Day',
                    'charge'    => $treturn->charge
                ];
            }),
        ];
    }
}
