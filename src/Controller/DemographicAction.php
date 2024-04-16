<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Messenger\Command\SaveDemographic;
use Detection\MobileDetect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class DemographicAction extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('/demographic/{id}', name: 'demographic', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Answer $answer): Response
    {
        if ($answer->getCompletedAt() !== null) {
            return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
        }
        $command = new SaveDemographic(
            $answer->getId(),
        );
        $form = $this->createForm(AnswerType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Catch and handle validation exception
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
        }

        return $this->render('test/demographic.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
