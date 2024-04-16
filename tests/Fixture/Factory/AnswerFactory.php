<?php

declare(strict_types=1);

namespace App\Tests\Fixture\Factory;

use App\Entity\Answer;
use App\Entity\Test;
use App\Enum\Education;
use App\Enum\Gender;
use App\Enum\Hobby;
use App\Repository\AnswerRepository;
use Fixture\Factory\TestFactory;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Answer>
 * @method        Test|Proxy                     create(array|callable $attributes = [])
 * @method static Test|Proxy                     createOne(array $attributes = [])
 * @method static Test[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AnswerRepository|RepositoryProxy repository()
 */
class AnswerFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'id' => Uuid::v4(),
            'test' => TestFactory::createOne(),
            'isMobile' => self::faker()->boolean(),
            'gender' => self::faker()->randomElement(Gender::cases()),
            'age' => self::faker()->numberBetween(18, 99),
            'education' => self::faker()->randomElement(Education::cases()),
            'hobbies' => self::faker()->randomElements(Hobby::cases(), self::faker()->numberBetween(1, 8)),
        ];
    }

    protected static function getClass(): string
    {
        return Answer::class;
    }
}
