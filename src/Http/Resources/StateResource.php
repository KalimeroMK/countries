<?php

namespace Kalimeromk\Countries\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Kalimeromk\Models\State */
class StateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'country_id' => $this->country_id,

            'country' => new CountryResource($this->whenLoaded('country')),
        ];
    }
}
