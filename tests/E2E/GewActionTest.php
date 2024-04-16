<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use App\Entity\Answer;
use App\Tests\Fixture\Factory\AnswerFactory;
use Zenstruck\Foundry\Proxy;

class GewActionTest extends BaseE2ETestCaseTest
{
    public function testWheelSubmissionEmptyWheelSubmitted(): void
    {
        $answer = AnswerFactory::createOne();

        $browser = $this->browser()
            ->followRedirects()
            ->visit('/gew/'.$answer->getId()->toRfc4122())
            ->assertSuccessful()
            ->click('Saglabāt');

        /** @var Proxy<Answer> $freshAnswer */
        $freshAnswer = $answer->refresh();
        $browser->assertOn('/bio-motion/'.$freshAnswer->getId()->toRfc4122());
        self::assertEmpty($freshAnswer->getGewEmotions());
        self::assertEmpty($freshAnswer->getCompletedAt());
        self::assertEmpty($freshAnswer->getCustomEmotion());
    }
}
