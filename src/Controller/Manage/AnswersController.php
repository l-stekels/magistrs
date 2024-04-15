<?php

declare(strict_types=1);

namespace App\Controller\Manage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnswersController extends AbstractController
{
    #[Route('/manage/answers', name: 'manage_answers_index', methods: ['GET'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MANAGER');
        // TODO: Check which tests manager can see and give access to them

        return $this->render('manage/manager/index.html.twig');
    }
}
