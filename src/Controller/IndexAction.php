<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Test;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexAction extends AbstractController
{
    public function __construct(
        private readonly TestRepository $testRepo,
    ) {
    }

    #[Route('/{id?}', name: 'home', methods: ['GET'])]
    public function index(?Test $test): Response
    {
        if (!$test instanceof Test) {
            /** @var Test $test */
            $test = $this->testRepo->findOneBy([
                'isEyeTracking' => false,
            ]);
        }

        return $this->render('index.html.twig', compact('test'));
    }
}
