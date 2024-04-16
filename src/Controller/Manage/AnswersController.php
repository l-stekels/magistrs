<?php

declare(strict_types=1);

namespace App\Controller\Manage;

use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnswersController extends AbstractController
{
    public function __construct(
        private readonly TestRepository $testRepo,
    ) {
    }

    #[Route('/manage/answers', name: 'manage_answers_index', methods: ['GET'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        return $this->render('manage/manager/index.html.twig', [
            'tests' => $this->testRepo->findForUser($this->isGranted('ROLE_ADMIN')),
        ]);
    }
}
