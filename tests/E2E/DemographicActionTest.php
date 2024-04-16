<?php

declare(strict_types=1);

namespace App\Tests\E2E;

use App\Enum\Education;
use App\Enum\Gender;
use App\Enum\Hobby;
use App\Tests\Fixture\Factory\AnswerFactory;
use Fixture\Factory\TestFactory;
use PHPUnit\Framework\Attributes\DataProvider;
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
        $test = TestFactory::createOne();
        $gender = Gender::cases()[array_rand(Gender::cases())];
        $age = random_int(18, 99);
        $education = Education::cases()[array_rand(Education::cases())];

        $this->browser()
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
        self::assertSame($answer->getGender(), $gender);
        self::assertSame($answer->getAge(), $age);
        self::assertSame($answer->getEducation(), $education);
        self::assertSame($answer->getHobbies(), [Hobby::GRAMATAS, Hobby::FOTO, Hobby::MEDITACIJA]);
    }
}
