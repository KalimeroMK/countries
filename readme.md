# Countries

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/kalimeromk/countries.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/kalimeromk/countries.svg?style=flat-square)](https://packagist.org/packages/kalimeromk/countries)

## Usage

Laravel Countries is a package for Laravel, providing Almost ISO 3166_2, 3166_3, currency, Capital and more for all
countries including states and cities .

## Installation

You can install this package via Composer:

``composer require kalimeromk/countries``

#### Or form composer.json file ####

Add `kalimeromk/countries` to `composer.json`.

    "kalimeromk/countries": "*"

Run `composer update` to pull down the latest version of Country List.

Edit `app/config/app.php` and add the `provider` and `filter`

    'providers' => [
        'Kalimeromk\Countries\CountriesServiceProvider',
    ]

Now add the alias.

    'aliases' => [
        'Countries' => 'Kalimeromk\Countries\CountriesServiceProvider',
    ]

## Model

You can start by publishing the configuration. This is an optional step, it contains the table names for needed table
and does not need to
be altered. If the default names `countries`,`states`,`cities` suits you, leave it. Otherwise, run the following command

    $ php artisan vendor:publish --tag=countries-config

If need to make some changes to migrate file use flowing command to generate the migration file:

    $ php artisan vendor:publish --tag=countries-migration

It will generate the migration in databases/migrations dir

In the package we have tree models `Country`,`State`,`City` with needed relation to be used out of the box but if
changes just extend models :)

To finish everything need to seed the data into the table, so 1st need to run

    $ php artisan vendor:publish --tag=countries-seeders 

and add this code to DatabaseSeeder class

    //Seed the countries
     $this->call(CountriesSeeder::class);
     $this->call(StatesSeeder::class);
     $this->call(CitiesSeeder::class);

You may now run it with the artisan migrate command:

    $ php artisan migrate --seed

After running this command the filled countries table will be available

## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Zoran](https://github.com/kalimeromk)
- [All Contributors](https://github.com/kalimeromk/countries/contributors)

## Security

If you discover any security-related issues, please email zbogoevski@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.