<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'user_id' => $this->id,
            'name' => $this->name,
            'email' =>$this->email,
            'flat_id' => $this->flat_id,
            'avatar_url' => $this->getAvatarUrl(),
            'color' => $this->getColor(),
            'roles' => $this->getRoles(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
