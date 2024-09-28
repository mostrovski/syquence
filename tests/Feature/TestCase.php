<?php declare(strict_types=1);

namespace App\Tests\Feature;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

abstract class TestCase extends ApiTestCase
{
    protected Client $http;

    protected function setUp(): void
    {
        $this->http = static::createClient();
    }
}
