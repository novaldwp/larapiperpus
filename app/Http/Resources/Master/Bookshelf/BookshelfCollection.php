<?php

namespace App\Http\Resources\Master\Bookshelf;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookshelfCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($bookshelf) {
                return [
                    'id'    => $bookshelf->id,
                    'name'  => $bookshelf->name,
                    'category'  => [
                        'id'    => $bookshelf->category->id,
                        'name'  => $bookshelf->category->name
                    ]
                ];
            })
        ];
    }
}
