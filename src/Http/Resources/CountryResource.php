<?php

namespace Kalimeromk\Countries\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Kalimeromk\Models\Country */
class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'capital' => $this->capital,
            'citizenship' => $this->citizenship,
            'country_code' => $this->country_code,
            'currency' => $this->currency,
            'currency_code' => $this->currency_code,
            'currency_sub_unit' => $this->currency_sub_unit,
            'currency_symbol' => $this->currency_symbol,
            'currency_decimals' => $this->currency_decimals,
            'full_name' => $this->full_name,
            'iso_3166_2' => $this->iso_3166_2,
            'iso_3166_3' => $this->iso_3166_3,
            'name' => $this->name,
            'region_code' => $this->region_code,
            'sub_region_code' => $this->sub_region_code,
            'eea' => $this->eea,
            'calling_code' => $this->calling_code,
            'flag' => $this->flag,
        ];
    }
}
