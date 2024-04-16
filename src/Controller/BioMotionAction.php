<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Enum\WalkerEmotion;
use App\Form\BioMotionType;
use App\Messenger\Command\AnswerThreshold;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class BioMotionAction extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
    }

    #[Route('/bio-motion/{id}', name: 'bio_motion_start', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Answer $answer): Response
    {
        if ($answer->getCompletedAt() !== null) {
            return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
        }
        $command = new AnswerThreshold(
            $answer->getId(),
            $answer->getWalkerEmotion(),
        );
        $form = $this->createForm(BioMotionType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->commandBus->dispatch($command);

                return $this->redirectToRoute('fin', ['id' => $answer->getId()]);
            } catch (\Throwable) {
                $this->addFlash('error', 'Diemžēl neizdevās saglabāt atbildi, lūdzu mēģiniet vēlreiz');

                return $this->redirectToRoute('bio_motion_start', ['id' => $answer->getId()]);
            }
        }

        return $this->render('test/bio_motion.html.twig', [
            'emotion' => $answer->getWalkerEmotion(),
            'form' => $form->createView(),
        ]);
    }
}
