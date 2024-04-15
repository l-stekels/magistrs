<?php

declare(strict_types=1);

namespace App\Controller\Manage;

use App\Entity\Test;
use App\Form\TestType;
use App\Messenger\Command\CreateTest;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Uid\Uuid;

class TestsController extends AbstractController
{
    public function __construct(
        private readonly TestRepository $testRepo,
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('/manage/tests', name: 'manage_tests_index', methods: ['GET'])]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('manage/admin/index.html.twig', [
            'tests' => $this->testRepo->findAll(),
        ]);
    }

    #[Route('/manage/tests/new', name: 'manage_tests_new', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $command = new CreateTest(
            Uuid::v4(),
        );
        $form = $this->createForm(TestType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('manage_tests_show', ['id' => $command->id]);
        }

        return $this->render('manage/admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/manage/tests/{id}', name: 'manage_tests_show', requirements: ['id' => Requirement::UUID_V4], methods: ['GET'])]
    public function show(Test $test): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('manage/admin/show.html.twig', [
            'test' => $test,
        ]);
    }

    #[Route('/manage/tests/{id}/edit', name: 'manage_tests_edit', requirements: ['id' => Requirement::UUID_V4], methods: ['GET', 'POST',])]
    public function edit(Test $test): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('manage/admin/edit.html.twig', [
            'test' => $test,
        ]);
    }
}
