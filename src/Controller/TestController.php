<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
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

    #[Route('/test', name: 'test_start')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig');
    }

    #[Route('/demografija', name: 'demografija')]
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

    #[Route('/bio-motion', name: 'bio_motion_start')]
    public function bioMotionStart(Answer $answer): Response
    {
        return $this->render('test/bio_motion_start.html.twig');
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
