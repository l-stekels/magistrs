<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class IndexActionTest extends WebTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;

    public function testIndexWithNoTests(): void
    {
        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->assertSeeIn('h1', 'Bioloģiskās kustības emociju atpazīšanas sliekšņa noteikšanas tests')
            ->assertSeeIn('p', 'Sveiki!')
            ->assertNotSeeIn('a' , 'Sākt');
    }
}
