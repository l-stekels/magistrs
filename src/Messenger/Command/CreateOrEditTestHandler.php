<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use App\Entity\Test;
use App\Repository\TestRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateOrEditTestHandler
{
    public function __construct(
        private TestRepository $testRepository,
    ) {
    }

    public function __invoke(CreateOrEditTest $command): void
    {
        $test = $this->testRepository->find($command->id);
        if (null === $test) {
            $test = new Test($command->id);
        }
        $test->setTitle($command->getTitle());
        $test->setIsEyeTracking($command->isEyeTracking());
        $test->setIsShared($command->isShared());
        $this->testRepository->save($test);
    }
}
