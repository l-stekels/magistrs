<?php

declare(strict_types=1);

namespace Fixture\Factory;

use App\Entity\Test;
use App\Repository\TestRepository;
use Symfony\Component\Uid\Uuid;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Test>
 * @method        Test|Proxy                     create(array|callable $attributes = [])
 * @method static Test|Proxy                     createOne(array $attributes = [])
 * @method static Test[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static TestRepository|RepositoryProxy repository()
 */
class TestFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'id' => Uuid::v4(),
            'title' => self::faker()->sentence(2),
            'isEyeTracking' => false,
            'isShared' => false,
        ];
    }

    protected static function getClass(): string
    {
        return Test::class;
    }
}
