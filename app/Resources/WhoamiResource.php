<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WhoamiResource extends JsonResource
{
    /**
     * removing data wrapper from resource
     *
     * @var null
     */
    public static $wrap = null;

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role
        ];
    }

}
