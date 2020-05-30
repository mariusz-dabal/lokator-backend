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
            'flat_id' => $this->flat_id,
            'avatar_id' => $this->avatar_id,
            'color_id' => $this->color_id,
            'name' => $this->name,
            'email' =>$this->email,
            'roles' => $this->getRoles(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
