<?php

namespace App\Http\Resources\Inventory;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StockCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function($stock) {
                return [
                    'id' => $stock->id,
                    'book_id' => $stock->book_id,
                    'title'   => $stock->book->title,
                    'amount'  => $stock->amount,
                    'image' => public_path('images/'.(( $stock->book->image == "") ? "no_image.jpg":"book/thumb/".$stock->book->image))
                ];
            })
        ];
    }
}
