<?php

namespace Kalimeromk\Countries;

use Illuminate\Support\ServiceProvider;

class CountriesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->resourcePublish();
        $this->publishSeeder();
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function resourcePublish(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/country.php' => config_path('/country.php'),
        ], 'countries-config');

        $this->publishes([
            __DIR__ . '/../database/migrations/2023_02_22_195848_setup_countries_table.php' => database_path(
                'migrations/' . date('Y_m_d_His', time()) . '_create_countries_table.php'
            )
        ],
            'countries-migrations'
        );
        $this->publishes([
            __DIR__ . '/../database/migrations/2023_02_23_100908_create_state_table.php' => database_path(
                'migrations/' . date('Y_m_d_His', time()) . 'create_state_table.php'
            )
        ],
            'countries-migrations'
        );
        $this->publishes([
            __DIR__ . '/../database/migrations/2023_02_23_101131_setup_city_table.php' => database_path(
                'migrations/' . date('Y_m_d_His', time()) . 'setup_city_table.php'
            )
        ],
            'countries-migrations'
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerConfig();
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/country.php', 'country');
    }

    /**
     * @return void
     */
    public function publishSeeder(): void
    {
        if ($this->app->runningInConsole()) {
            if (!class_exists('CountriesSeeder')) {
                $this->publishes([
                    __DIR__ . '/../database/seeders/CountriesSeeder.php.stub' => app_path(
                        '/../database/seeders/CountriesSeeder.php'
                    ),
                    __DIR__ . '/../database/seeders/StatesSeeder.php.stub' => app_path(
                        '/../database/seeders/StatesSeeder.php'
                    ),
                    __DIR__ . '/../database/seeders/CitiesSeeder.php.stub' => app_path(
                        '/../database/seeders/CitiesSeeder.php'
                    ),
                ],
                    'countries-seeders'
                );
            }
        }
    }
}
