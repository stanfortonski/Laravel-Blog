<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PostResource extends JsonResource
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
            'contents' => $this->contents()->get()->values()->toArray(),
            'thumbnail' => $this->thumbnail,
            'author' => new UserResource($this->author),
            'tags' => $this->tags
        ];
    }
}
