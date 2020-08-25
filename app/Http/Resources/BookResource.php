<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'title' => $this->title,
            'annotation' => $this->annotation,
            'pages' => $this->pages,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'img'=>$this->img,
            'user' => $this->user,
            'author' => $this->authors,
        ];
    }
}
