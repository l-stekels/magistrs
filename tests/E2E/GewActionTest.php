<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use App\Tests\Fixture\Factory\AnswerFactory;
use Symfony\Component\Panther\PantherTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class GewActionTest extends PantherTestCase
{
    use HasBrowser;
    public function testWheelSubmission(): void
    {
        $answer = AnswerFactory::createOne();

        $browser = $this->browser()
            ->interceptRedirects()
            ->visit('/gew/'.$answer->getId()->toRfc4122())
            ->assertSuccessful()
            ->click('Saglabāt');

        $freshAnswer = $answer->refresh();
    }
}
