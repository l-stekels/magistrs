<?php

declare(strict_types=1);

namespace App\Messenger\Middleware;

interface LockableMessageInterface
{
    public function getLockKey(): string;
}
