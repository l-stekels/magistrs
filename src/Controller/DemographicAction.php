<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Test;
use App\Form\AnswerType;
use App\Messenger\Command\StartAnswer;
use Detection\Exception\MobileDetectException;
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
        private readonly MobileDetect $mobileDetect,
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('/demographic/{id}', name: 'demographic', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Test $test): Response
    {
        $this->mobileDetect->setUserAgent($request->headers->get('User-Agent'));
        try {
            $isMobile = $this->mobileDetect->isMobile();
        } catch (MobileDetectException) {
            $isMobile = false;
        }
        $command = new StartAnswer(
            Uuid::v4(),
            $isMobile,
            $test->getId(),
        );
        $form = $this->createForm(AnswerType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Catch and handle validation exception
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('emotion_wheel', ['id' => $command->id->toRfc4122()]);
        }

        return $this->render('test/demographic.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
