<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use Fixture\Factory\TestFactory;

class IndexActionTest extends BaseE2ETestCase
{
    public function testIndexWithNoTests(): void
    {
        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->assertSeeIn('h1', 'Bioloģiskās kustības emociju atpazīšanas sliekšņa noteikšanas tests')
            ->assertSeeIn('p', 'Sveiki!')
            ->assertNotSeeElement('a[href^="/demographic/"]');
    }

    public function testIndexWithRandomTest(): void
    {
        $test = TestFactory::createOne();

        $this->browser()
            ->visit('/')
            ->assertSuccessful()
            ->assertSeeIn('h1', 'Bioloģiskās kustības emociju atpazīšanas sliekšņa noteikšanas tests')
            ->assertSeeIn('p', 'Sveiki!')
            ->assertNotSeeElement('a[href^="/demographic/"]');
    }

    public function testIndexWithSpecificTest(): void
    {
        $test = TestFactory::createOne();
        $demographicLink = sprintf('/demographic/%s', $test->getId()->toRfc4122());

        $this->browser()
            ->visit(sprintf('/%s', $test->getId()->toRfc4122()))
            ->assertSuccessful()
            ->assertSeeIn('h1', 'Bioloģiskās kustības emociju atpazīšanas sliekšņa noteikšanas tests')
            ->assertSeeIn('p', 'Sveiki!')
            ->assertSeeElement("a[href='$demographicLink']")
            ->clickAndIntercept("a[href='$demographicLink']")
            ->assertSuccessful()
            ->assertOn($demographicLink);
    }
}
