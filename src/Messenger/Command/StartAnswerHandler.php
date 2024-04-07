<?php

declare(strict_types=1);

namespace App\Messenger\Command;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class StartAnswerHandler
{
    public function __invoke(StartAnswer $command): void
    {


    }
}
