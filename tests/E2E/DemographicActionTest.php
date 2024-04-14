<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Fixture\Factory\TestFactory;
use Symfony\Component\Panther\PantherTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DemographicActionTest extends PantherTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;


    public function testFormSubmission(): void
    {
        TestFactory::createOne();

        $this->browser()
            ->visit('/demographic')
            ->assertSuccessful()
            ->assertSee('Demogrāfiskie dati');
//        $client = static::createPantherClient();
//        $crawler = $client->request('GET', '/demographic');
//
//        // Find the form and submit it
//        $form = $crawler->selectButton('Saglabāt')->form();
//        $form['answer[age]'] = 20;
//        $form['answer[gender]'] = 'female';
//        $form['answer[education]'] = 'Fotogrāfēšana';
////        $form['answer[hobby]'] = 'Fotogrāfēšana';
//        $client->submit($form);
//        // Parse the URL and get the path
//
//        $path = parse_url($client->getCurrentURL(), PHP_URL_PATH);
//        // Assert that the path starts with '/bio-motion/'
//        $this->assertStringStartsWith('/bio-motion/', $path);
    }
}
