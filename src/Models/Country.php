<?php

namespace Kalimeromk\Countries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

/**
 * CountryList
 *
 */
class Country extends Model
{

    public $timestamps = false;

    protected $casts = [
        'currency_decimals' => 'int',
        'eea' => 'bool'
    ];

    protected $fillable = [
        'capital',
        'citizenship',
        'country_code',
        'currency',
        'currency_code',
        'currency_sub_unit',
        'currency_symbol',
        'currency_decimals',
        'full_name',
        'iso_3166_2',
        'iso_3166_3',
        'name',
        'region_code',
        'sub_region_code',
        'eea',
        'calling_code',
        'flag'
    ];

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = config('country.table_name');
    }

    /**
     * Get the countries from the JSON file, if it hasn't already been loaded.
     *
     * @return array
     */
    protected function getCountries(): array
    {
        static $countries;

        if (!isset($countries)) {
            $path = __DIR__ . '/../../database/seeders/import/countries.json';
            $countries = json_decode(file_get_contents($path), true);
        }

        return $countries;
    }

    /**
     * Returns a list of countries
     *
     * @param string|null $sort sort
     *
     * @return array
     */
    public function getList(string $sort = null): array
    {
        $countries = $this->getCountries();

        if ($sort !== null) {
            $validSorts = [
                'capital',
                'citizenship',
                'country-code',
                'currency',
                'currency_code',
                'currency_sub_unit',
                'full_name',
                'iso_3166_2',
                'iso_3166_3',
                'name',
                'region-code',
                'sub-region-code',
                'eea',
                'calling_code',
                'currency_symbol',
                'flag'
            ];
            if (!in_array($sort, $validSorts)) {
                throw new InvalidArgumentException("Invalid sort field '$sort'");
            }
            uasort($countries, function ($a, $b) use ($sort) {
                return strcasecmp($a[$sort] ?? '', $b[$sort] ?? '');
            });
        }

        return $countries;
    }

    /**
     * @return HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }


}
