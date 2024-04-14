<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class IndexActionTest extends PantherTestCase
{
    public function testIndex(): void
    {
        $client = static::createPantherClient(); // Your app is automatically started using the built-in web server
        $crawler = $client->request('GET', '/');

        self::assertPageTitleContains('Maģistra darbs');

        // Click on the button/link. Replace 'button-id' with the id or text of your button
        $link = $crawler->selectLink('Sākt')->link();
        $client->click($link);

        // Assert the current URL or page content to verify the redirection
        $this->assertSame('http://127.0.0.1:9080/demographic', $client->getCurrentURL());
    }
}
