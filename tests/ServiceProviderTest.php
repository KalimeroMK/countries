<?php

declare(strict_types=1);

namespace Kalimeromk\Countries\Tests;

use Kalimeromk\Countries\CountriesServiceProvider;

/**
 * Package auto-discovery instantiates whatever composer.json declares, so a
 * provider that does not exist or cannot boot is a fatal error on every request.
 */
final class ServiceProviderTest extends TestCase
{
    public function testTheDeclaredProviderExists(): void
    {
        $declared = json_decode((string) file_get_contents(__DIR__ . '/../composer.json'), true);

        foreach ($declared['extra']['laravel']['providers'] ?? [] as $provider) {
            $this->assertTrue(class_exists($provider), $provider . ' is declared for auto-discovery but does not exist');
        }
    }

    public function testTheProviderIsRegistered(): void
    {
        $this->assertNotNull($this->app->getProvider(CountriesServiceProvider::class));
    }
}
