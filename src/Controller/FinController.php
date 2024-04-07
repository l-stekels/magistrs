<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FinController extends AbstractController
{
    #[Route('/fin/{id}', name: 'fin', methods: ['GET'])]
    public function fin(Answer $answer): Response
    {
        // TODO: Calculate result and display something interesting

        return $this->render('test/fin.html.twig', [
            'answer' => $answer,
        ]);
    }
}
