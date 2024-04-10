<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogCollection extends JsonResource
{
    /**
     * @param $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'views' => $this->views,
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ],
            'publish_date' => $this->publish_date,
            'created_at' => $this->created_at,
        ];
    }
}
