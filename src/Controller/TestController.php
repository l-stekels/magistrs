<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Enum\Emotion;
use App\Enum\WalkerEmotion;
use App\Form\AnswerType;
use App\Messenger\Command\AnswerEmotion;
use App\Messenger\Command\AnswerThreshold;
use App\Messenger\Command\StartAnswer;
use App\Repository\TestRepository;
use Detection\Exception\MobileDetectException;
use Detection\MobileDetect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class TestController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly MobileDetect $mobileDetect,
        private readonly TestRepository $testRepo,
    ) {
    }

    #[Route('/demographic', name: 'demographic', methods: ['GET', 'POST'])]
    public function demographic(Request $request): Response
    {
        $this->mobileDetect->setUserAgent($request->headers->get('User-Agent'));
        try {
            $isMobile = $this->mobileDetect->isMobile();
        } catch (MobileDetectException) {
            $isMobile = false;
        }
        $test = $this->testRepo->getActiveTest();
        $command = new StartAnswer(
            Uuid::v4(),
            $isMobile,
            $test->getId(),
        );
        $form = $this->createForm(AnswerType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('bio_motion_start', ['id' => $command->id->toRfc4122()]);
        }

        return $this->render('test/demographic.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/bio-motion/{id}', name: 'bio_motion_start', methods: ['GET', 'POST'])]
    public function bioMotionStart(Request $request, Answer $answer): Response
    {
        if ($answer->getCompletedAt() !== null) {
            return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
        }
        // Determine walker emotion
        $walkerEmotion = WalkerEmotion::random();
        $command = new AnswerThreshold(
            $answer->getId(),
            $walkerEmotion,
        );
        if ($request->isMethod('GET')) {
            return $this->render('test/bio_motion.html.twig', [
                'emotion' => $walkerEmotion,
            ]);
        }
        $csrfToken = $request->getPayload()->get('token');
        if (!$this->isCsrfTokenValid('save-threshold', $csrfToken)) {
            return new Response(':(');
        }

        $command->setThreshold((int) $request->getPayload()->get('threshold'));
        $command->setGuessedEmotion(WalkerEmotion::tryFrom($request->getPayload()->get('guessed-emotion')));
        try {
            $this->commandBus->dispatch($command);
        } catch (\Throwable) {
            $this->addFlash('error', 'Diemžēl neizdevās saglabāt atbildi, lūdzu mēģiniet vēlreiz');
            return $this->redirectToRoute('bio_motion_start', ['id' => $answer->getId()]);
        }

        return $this->redirectToRoute('emotion_wheel', ['id' => $answer->getId()]);
    }

    #[Route('/gew/{id}', name: 'emotion_wheel', methods: ['GET', 'POST'])]
    public function wheel(Request $request, Answer $answer): Response
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
        $intensity = null !== $values['intensity'] ? (int) $values['intensity'] : null;
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
