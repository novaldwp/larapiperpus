<?php

namespace App\Http\Resources\Transaction\TReturn;

use Illuminate\Http\Resources\Json\JsonResource;

class ReturnResource extends JsonResource
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
            'code'      => $this->loan->code,
            'late'      => $this->late_day,
            'charge'    => $this->charge,
            'book'      => [
                'id'        => $this->loan->book->id,
                'code'      => $this->loan->book->code,
                'isbn'      => $this->loan->book->isbn,
                'title'     => $this->loan->book->title,
                'category'  => $this->loan->book->category->name,
                'author'    => $this->loan->book->author->name,
                'publisher' => $this->loan->book->publisher->name
            ],
        ];
    }
}
