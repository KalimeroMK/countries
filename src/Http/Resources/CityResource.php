<?php

namespace Kalimeromk\Countries\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Kalimeromk\Models\City */
class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'state_id' => $this->state_id,

            'state' => new StateResource($this->whenLoaded('state')),
        ];
    }
}
