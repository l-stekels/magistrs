<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Test;
use App\Enum\Emotion;
use App\Messenger\Command\AnswerEmotion;
use Detection\Exception\MobileDetectException;
use Detection\MobileDetect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class GewAction extends AbstractController
{
    public function __construct(
        private readonly MobileDetect $mobileDetect,
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('/gew/{id}', name: 'emotion_wheel', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Test $test): Response
    {
        $this->mobileDetect->setUserAgent($request->headers->get('User-Agent'));
        try {
            $isMobile = $this->mobileDetect->isMobile();
        } catch (MobileDetectException) {
            $isMobile = false;
        }
        $command = new AnswerEmotion(
            $test->getId(),
            $id = Uuid::v4(),
            $isMobile,
        );
        if ($request->isMethod('GET')) {
            return $this->render('test/gew.html.twig', [
                'wheelEmotions' => Emotion::cases(),
            ]);
        }
        $csrfToken = $request->getPayload()->get('token');
        if (!$this->isCsrfTokenValid('save-emotion', $csrfToken)) {
            return new Response(':(');
        }

        $rawEmotions = json_decode($request->request->get('emotion', '[]'), true, flags: JSON_THROW_ON_ERROR);
        $emotionsMapped = [] !== $rawEmotions ? array_combine(
            Emotion::values(),
            $rawEmotions,
        ) : [];
        foreach ($emotionsMapped as $emotion => $intensity) {
            if ($intensity === null) {
                continue;
            }
            $command->addEmotion($emotion, $intensity);
        }
        $customEmotion = $request->request->get('custom_emotion') !== '' ? $request->request->get('custom_emotion') : null;
        $command->setCustomEmotion($customEmotion);
        try {
            $this->commandBus->dispatch($command);
        } catch (\Throwable) {
            $this->addFlash('error', 'Diemžēl neizdevās saglabāt atbildi, lūdzu mēģiniet vēlreiz');

            return $this->redirectToRoute('emotion_wheel', ['id' => $test->getId()]);
        }

        return $this->redirectToRoute('bio_motion_start', ['id' => $id]);
    }
}
