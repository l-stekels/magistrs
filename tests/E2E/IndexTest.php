<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class IndexTest extends PantherTestCase
{
    public function testIndex(): void
    {
        $client = static::createPantherClient(); // Your app is automatically started using the built-in web server
        $client->request('GET', '/');

        self::assertPageTitleContains('Maģistra darbs');
    }
}
