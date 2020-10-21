<?php

namespace App\Http\Resources\Transaction\Loan;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LoanCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($loan){
                return [
                    'id'        => $loan->id,
                    'code'      => $loan->code,
                    'title'     => $loan->book->title,
                    'borrower'  => $loan->member->first_name.' '.$loan->member->last_name,
                    'return'    => $loan->return,
                    'status'    => $loan->status == 0 ? "Dipinjam":"Sudah Kembali"
                ];
            }),
        ];
    }
}
