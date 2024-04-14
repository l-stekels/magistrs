<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Enum\Emotion;
use App\Messenger\Command\AnswerEmotion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class GewAction extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('/gew/{id}', name: 'emotion_wheel', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Answer $answer): Response
    {
        if ($answer->getCompletedAt() !== null) {
            return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
        }
        $command = new AnswerEmotion(
            $answer->getId(),
        );
        if ($request->isMethod('GET')) {
            return $this->render('test/gew.html.twig');
        }
        $csrfToken = $request->getPayload()->get('token');
        if (!$this->isCsrfTokenValid('save-emotion', $csrfToken)) {
            return new Response(':(');
        }
        // Map values to null
        $values = array_map(static fn (string $value) => "" === $value ? null : $value, $request->request->all());
        // Map number of emotion to the correct enum value
        $emotion = Emotion::pick($values['emotion']);
        $intensity = null !== $values['intensity'] ? (int)$values['intensity'] : null;
        $command->setCustomEmotion($values['custom-emotion']);
        $command->setIntensity($intensity);
        $command->setEmotion($emotion);
        try {
            $this->commandBus->dispatch($command);
        } catch (\Throwable) {
            $this->addFlash('error', 'Diemžēl neizdevās saglabāt atbildi, lūdzu mēģiniet vēlreiz');

            return $this->redirectToRoute('emotion_wheel', ['id' => $answer->getId()]);
        }

        return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
    }
}
