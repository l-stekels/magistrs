<?php

declare(strict_types=1);

namespace App\Controller\Manage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexAction extends AbstractController
{
    #[Route('/manage', name: 'manage', methods: ['GET'])]
    public function __invoke(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('manage_tests_index');
        }
        return $this->redirectToRoute('manage_answers_index');
    }
}
