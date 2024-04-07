<?php

declare(strict_types=1);

namespace App\Messenger\Middleware;

use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;

/**
 * {@see https://developer.happyr.com/symfony-lock-and-messenger-component}.
 */
readonly class LockMiddleware implements MiddlewareInterface
{
    public function __construct(private LockFactory $lockFactory)
    {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (!$message instanceof LockableMessageInterface) {
            return $stack->next()->handle($envelope, $stack);
        }
        /**
         * Only need to acquire a lock once per message,
         * so if a message is in sync transport it could go through the middleware twice,and we only need to lock it the first time.
         */
        $receivedStamp = $envelope->last(ReceivedStamp::class);
        if ('sync' === $receivedStamp?->getTransportName()) {
            return $stack->next()->handle($envelope, $stack);
        }
        $lock = $this->lockFactory->createLock($message->getLockKey(), 60);
        $lock->acquire(true);

        try {
            return $stack->next()->handle($envelope, $stack);
        } finally {
            $lock->release();
        }
    }
}
