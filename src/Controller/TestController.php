<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test_start')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig');
    }

    #[Route('/demografija', name: 'demografija')]
    public function demographic(): Response
    {
        // TODO: Ielādē eksistējošo testu no datubāzes
        // TODO: Vismaz vienam testam jāaksistē, jāpievieno default migrācija

        // Šajā brīdī sākas testa izpilde, varbūt ir jēga taisīt te jau formu?




        return $this->render('test/demographic.html.twig');
    }

    #[Route('/test/{id}/finish', name: 'test_finish')]
    public function name(): Response
    {
        return $this->render('test/finish.html.twig');
    }

    #[Route('/wheel', name: 'wheel')]
    public function wheel(): Response
    {
        return $this->render('wheel.html.twig');
    }
}
