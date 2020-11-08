<?php

namespace App\Http\Resources\Master\Bookshelf;

use Illuminate\Http\Resources\Json\JsonResource;

class BookshelfResource extends JsonResource
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
            'name'      => $this->name,
            'category'  => [
                'id'    => $this->category->id,
                'name'  => $this->category->name
            ]
        ];
    }
}
