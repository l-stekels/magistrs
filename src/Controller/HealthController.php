<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Routing\Attribute\Route;


class HealthController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly LockFactory $lock,
    ) {
    }

    #[Route('/health', name: 'health')]
    public function index(): Response
    {
        $lock = null;
        try {
            $lock = $this->lock->createLock('health');
            $lock->acquire(true);
            $this->em->getConnection()->prepare('SELECT 1')->executeStatement();
        } catch (\Throwable) {
            return new Response('ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $lock?->release();
        }

        return new Response('OK');
    }
}
