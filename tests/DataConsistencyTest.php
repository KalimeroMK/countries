<?php

namespace Kalimeromk\Countries\Tests;

/**
 * The seed data must join: every state's country_id must be a key of
 * countries.json, and every city's state_id must exist in states.json.
 * Regression test for the broken country_id id-space in states.json.
 */
class DataConsistencyTest extends TestCase
{
    private static function importPath(string $file): string
    {
        return __DIR__.'/../database/seeders/import/'.$file;
    }

    public function test_every_state_references_a_known_country(): void
    {
        $countries = json_decode((string) file_get_contents(self::importPath('countries.json')), true);
        $countryIds = array_map('intval', array_keys($countries));

        $states = json_decode((string) file_get_contents(self::importPath('states.json')), true);
        $this->assertNotEmpty($states);

        foreach ($states as $state) {
            $this->assertContains(
                (int) $state['country_id'],
                $countryIds,
                "State {$state['name']} references unknown country_id {$state['country_id']}"
            );
        }
    }

    public function test_every_city_references_a_known_state(): void
    {
        $states = json_decode((string) file_get_contents(self::importPath('states.json')), true);
        $stateIds = array_map('intval', array_column($states, 'id'));

        $cities = json_decode((string) file_get_contents(self::importPath('cities.json')), true);
        $this->assertNotEmpty($cities);

        foreach ($cities as $city) {
            $this->assertContains(
                (int) $city['state_id'],
                $stateIds,
                "City {$city['name']} references unknown state_id {$city['state_id']}"
            );
        }
    }

    public function test_us_states_are_actually_us_states(): void
    {
        $countries = json_decode((string) file_get_contents(self::importPath('countries.json')), true);
        $isoToKey = [];
        foreach ($countries as $key => $country) {
            $isoToKey[$country['iso_3166_2']] = (int) $key;
        }

        $states = json_decode((string) file_get_contents(self::importPath('states.json')), true);
        $usStates = array_column(
            array_filter($states, fn ($s) => $s['country_id'] === $isoToKey['US']),
            'name'
        );

        foreach (['California', 'Texas', 'New York', 'Florida'] as $expected) {
            $this->assertContains($expected, $usStates);
        }
        $this->assertNotContains('Saint Croix', $usStates); // Virgin Islands, not US
    }
}
