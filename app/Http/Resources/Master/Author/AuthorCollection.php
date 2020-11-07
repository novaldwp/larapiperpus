<?php

namespace App\Http\Resources\Master\Author;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthorCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($author) {
                return [
                    'id'    => $author->id,
                    'name'  => $author->name
                ];
            }),
        ];
    }
}
