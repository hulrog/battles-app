<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BattleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'map' => new MapResource($this->resource->map),
            'size' => $this->resource->army1 . " VS " . $this->resource->army2,
            'player1' => new UserResource($this->resource->player1),
            'player2' => new UserResource($this->resource->player2),
            'winner' => new UserResource($this->resource->winner)
        ];
    }
}
