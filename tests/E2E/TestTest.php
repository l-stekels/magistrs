<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class TestTest extends PantherTestCase
{
    public function testDemographicSubmitEmptyForm(): void
    {
        $client = static::createPantherClient(); // Your app is automatically started using the built-in web server
        $crawler = $client->request('GET', '/demographic');

        // Find the form and submit it
        $form = $crawler->selectButton('Saglabāt')->form();
        $client->submit($form);
        // Assert that the URL has not changed
        $this->assertSame('http://127.0.0.1:9080/demographic', $client->getCurrentURL());
    }

    public function testDemographicSubmit(): void
    {
        $client = static::createPantherClient(); // Your app is automatically started using the built-in web server
        $crawler = $client->request('GET', '/demographic');

        // Find the form and submit it
        $form = $crawler->selectButton('Saglabāt')->form();
        $form['answer[age]'] = 20;
        $form['answer[gender]'] = 'female';
        $client->submit($form);
        // Parse the URL and get the path
        $path = parse_url($client->getCurrentURL(), PHP_URL_PATH);
        // Assert that the path starts with '/bio-motion/'
        $this->assertStringStartsWith('/bio-motion/', $path);
    }
}
