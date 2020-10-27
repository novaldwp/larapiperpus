<?php

namespace App\Http\Resources\Main;

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
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'code' => $this->code,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'publication_year' => $this->publication_year,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'publisher_id' => $this->publisher->name,
            'author_id' => $this->author_id,
            'bookshelf_id' => $this->bookshelf_id,
            // 'created_at'    => $this->created_at->format('d-m-Y'),
            // 'updated_at'    => $this->updated_at->format('d-m-Y')
        ];
    }
}
