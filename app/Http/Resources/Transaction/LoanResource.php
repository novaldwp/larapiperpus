<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'code'      => $this->code,
            'return'    => $this->return,
            'status'    => $this->status == 0 ? "Dipinjam":"Sudah Kembali",
            'book'      => [
                    'id'    => $this->book_id,
                    'title' => $this->book->title,
            ],
            'member'    => [
                    'id' => $this->member_id,
                    'firstName' => $this->member->first_name,
                    'lastName' => $this->member->last_name,
                    'fullName' => $this->member->first_name.' '.$this->member->last_name
            ],
            'user'      => [
                    'id' => $this->user_id,
                    'name' => $this->user->name
            ]
        ];
    }
}
