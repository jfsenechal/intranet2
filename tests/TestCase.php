<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var array<int, string|null> */
    protected array $connectionsToTransact = [
        null,
        'mariadb',
        'maria-mailing-list',
        'maria-security',
        'maria-pst',
    ];

    protected function refreshApplication(): void
    {
        parent::refreshApplication();

        $sqliteConfig = [
            'driver' => 'sqlite',
            'database' => database_path('testing.sqlite'),
            'prefix' => '',
            'foreign_key_constraints' => true,
        ];

        $this->app['config']->set('database.connections.sqlite', $sqliteConfig);
        $this->app['config']->set('database.connections.mariadb', $sqliteConfig);
        $this->app['config']->set('database.connections.maria-mailing-list', $sqliteConfig);
        $this->app['config']->set('database.connections.maria-security', $sqliteConfig);
        $this->app['config']->set('database.connections.maria-pst', $sqliteConfig);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create([
            'name' => config('app.default_user.name'),
            'email' => config('app.default_user.email'),
            'password' => config('app.default_user.password'),
        ]));

        $this->withoutVite();
    }
}
