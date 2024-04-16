<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexAction extends AbstractController
{
    #[Route('/{id?}', name: 'home', methods: ['GET'])]
    public function index(?Test $test): Response
    {
        return $this->render('index.html.twig', compact('test'));
    }
}
