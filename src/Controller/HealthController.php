<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Routing\Attribute\Route;


class HealthController extends AbstractController
{
    public function __construct(
        private readonly TestRepository $testRepo,
        private readonly LockFactory $lock,
    ) {
    }

    #[Route('/health', name: 'health')]
    public function index(): Response
    {
        $status = 'OK';
        $lock = null;
        try {
            $lock = $this->lock->createLock('health');
            $lock->acquire(true);
            $this->testRepo->getActiveTest();
        } catch (\Throwable) {
            $status = 'ERROR';
        } finally {
            $lock?->release();
        }

        return $this->render('health/index.html.twig', compact('status'));
    }
}
