<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use App\Enum\Education;
use App\Enum\Gender;
use App\Enum\Hobby;
use App\Tests\Fixture\Factory\AnswerFactory;
use Fixture\Factory\TestFactory;

class DemographicActionTest extends BaseE2ETestCase
{
    public function testFormSubmission(): void
    {
        $test = TestFactory::createOne();
        $gender = Gender::cases()[array_rand(Gender::cases())];
        $age = random_int(18, 99);
        $education = Education::cases()[array_rand(Education::cases())];

        $browser = $this->browser()
            ->interceptRedirects()
            ->visit('/demographic/'.$test->getId()->toRfc4122())
            ->assertSuccessful()
            ->fillField('answer[gender]', $gender->value)
            ->fillField('answer[age]', (string)$age)
            ->selectField('answer[education]', $education->value)
            ->selectField('answer_hobbies_0', Hobby::GRAMATAS->value)
            ->selectField('answer_hobbies_1', Hobby::FOTO->value)
            ->selectField('answer_hobbies_13', Hobby::MEDITACIJA->value)
            ->click('Saglabāt');

        $answer = AnswerFactory::repository()->findOneBy([
            'test' => $test,
        ]);
        $browser->assertRedirectedTo('/gew/'.$answer->getId()->toRfc4122());
        self::assertSame($answer->getGender(), $gender);
        self::assertSame($answer->getAge(), $age);
        self::assertSame($answer->getEducation(), $education);
        self::assertSame($answer->getHobbies(), [Hobby::GRAMATAS, Hobby::FOTO, Hobby::MEDITACIJA]);
    }
}
