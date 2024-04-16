<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Routing\Attribute\Route;

class HealthAction extends AbstractController
{
    public function __construct(
        private readonly TestRepository $testRepo,
        private readonly LockFactory $lock,
    ) {
    }

    #[Route('/health', name: 'health')]
    public function __invoke(): Response
    {
        $lock = null;
        try {
            $lock = $this->lock->createLock('health');
            $lock->acquire(true);
            $this->testRepo->healthTest();
        } catch (\Throwable) {
            return new JsonResponse(['status' => 'ERROR'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $lock?->release();
        }

        return new JsonResponse(['status' => 'OK']);
    }
}
