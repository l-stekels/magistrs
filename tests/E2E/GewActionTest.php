<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use App\Tests\Fixture\Factory\AnswerFactory;
use Fixture\Factory\TestFactory;

class GewActionTest extends BaseE2ETestCase
{
    public function testWheelSubmissionEmptyWheelSubmitted(): void
    {
        $test = TestFactory::createOne();

        $browser = $this->browser()
            ->followRedirects()
            ->visit('/gew/'.$test->getId()->toRfc4122())
            ->assertSuccessful()
            ->click('Saglabāt');

        $answer = AnswerFactory::repository()->findOneBy(['test' => $test]);
        $browser->assertOn('/bio-motion/'.$answer->getId()->toRfc4122());
        self::assertEmpty($answer->getGewEmotions());
        self::assertEmpty($answer->getCompletedAt());
        self::assertEmpty($answer->getCustomEmotion());
        self::assertNotNull($answer->getWalkerEmotion(), 'Walker emotion should be set at the end of this step');
    }
    // TODO: Determine how to test clicks on different parts of the wheel
}
