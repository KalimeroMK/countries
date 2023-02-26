<?php

/**
 * Created by Zoran Shefot Bogoevski.
 */

namespace Kalimeromk\Countries\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

/**
 * Class City
 *
 * @property int $id
 * @property string $name
 * @property int $state_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @property-read City $cities
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereStateId($value)
 * @method static Builder|City whereUpdatedAt($value)
 */
class City extends Model
{

    protected $table = 'cities';

    protected $casts = [
        'state_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'state_id',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }


    protected function getCity(): array
    {
        static $countries;

        if (!isset($countries)) {
            $path = __DIR__ . '/../../database/seeders/import/cities.json';
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
        $cities = $this->getCity();

        if ($sort !== null) {
            $validSorts = [
                'name',
                'state_id',
                'create_ad',
                'update_at'
            ];
            if (!in_array($sort, $validSorts)) {
                throw new InvalidArgumentException("Invalid sort field '$sort'");
            }
            uasort($cities, function ($a, $b) use ($sort) {
                return strcasecmp($a[$sort] ?? '', $b[$sort] ?? '');
            });
        }
        return $cities;
    }
}
