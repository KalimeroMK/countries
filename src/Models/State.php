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
 * Class State
 *
 * @property int $id
 * @property string $name
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Country $country
 * @package App\Models
 * @method static Builder|State newModelQuery()
 * @method static Builder|State newQuery()
 * @method static Builder|State query()
 * @method static Builder|State whereCountryId($value)
 * @method static Builder|State whereCreatedAt($value)
 * @method static Builder|State whereId($value)
 * @method static Builder|State whereName($value)
 * @method static Builder|State whereUpdatedAt($value)
 */
class State extends Model
{
    protected $table = 'states';

    protected $casts = [
        'country_id' => 'int',
    ];

    protected $fillable = [
        'name',
        'country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected function getStates(): array
    {
        static $states;

        if (!isset($states)) {
            $path = __DIR__ . '/../../database/seeders/import/states.json';
            $states = json_decode(file_get_contents($path), true);
        }

        return $states;
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
        $states = $this->getStates();

        if ($sort !== null) {
            $validSorts = [
                'name',
                'country_id',
                'created_at',
                'updated_at'
            ];
            if (!in_array($sort, $validSorts)) {
                throw new InvalidArgumentException("Invalid sort field '$sort'");
            }
            uasort($states, function ($a, $b) use ($sort) {
                return strcasecmp($a[$sort] ?? '', $b[$sort] ?? '');
            });
        }
        return $states;
    }
}