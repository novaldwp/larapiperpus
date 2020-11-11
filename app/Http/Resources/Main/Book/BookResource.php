<?php

namespace App\Http\Resources\Main\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'isbn'      => $this->isbn,
            'title'     => $this->title,
            'publisher' => [
                'id'    => $this->publisher->id,
                'name'  => $this->publisher->name
            ],
            'author'    => [
                'id'    => $this->author->id,
                'name'  => $this->author->name
            ],
            'category'  => [
                'id'    => $this->category->id,
                'name'  => $this->category->name
            ],
            'bookshelf' => [
                'id'    => $this->bookshelf->id,
                'name'  => $this->bookshelf->name
            ],
            'image'     =>  [
                'full'  => public_path('images/'.(( $this->image == "") ? "no_image.jpg":"book/".$this->image)),
                'thumb' => public_path('images/'.(( $this->image == "") ? "no_image.jpg":"book/thumb/".$this->image))
            ]
        ];
    }
}
