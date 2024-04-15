<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Entity\Test;
use App\Repository\TestRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateTestHandler
{
    public function __construct(
        private TestRepository $testRepository,
    ) {
    }

    public function __invoke(CreateTest $command): void
    {
        $test = new Test(
            $command->id,
            $command->getTitle(),
        );
        $test->setEyeTracking($command->isEyeTracking());
        $test->setShared($command->isShared());
        $this->testRepository->save($test);
    }
}
