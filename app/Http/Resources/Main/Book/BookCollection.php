<?php

namespace App\Http\Resources\Main\Book;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
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
            'data'  => $this->collection->transform(function($book) {
                return [
                    'id'    => $book->id,
                    'isbn'  => $book->isbn,
                    'title' => $book->title,
                    'category' => [
                        'id'    => $book->category->id,
                        'name'  => $book->category->name
                    ],
                    'image' => public_path('images/'.(( $book->image == "") ? "no_image.jpg":"book/thumb/".$book->image))
                ];
            })
        ];
    }
}
