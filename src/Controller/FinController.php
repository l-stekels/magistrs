<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Enum\WalkerEmotion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FinController extends AbstractController
{
    #[Route('/fin/{id}', name: 'fin', methods: ['GET'])]
    public function fin(Answer $answer): Response
    {
        // TODO: Calculate result and display something interesting
        $walkerEmotion = match ($answer->getWalkerEmotion()) {
            WalkerEmotion::SAD => 'bēdīgs',
            WalkerEmotion::HAPPY => 'priecīgs',
            default => 'neatpazīts',
        };
        $score = $answer->getThreshold();

        return $this->render('test/fin.html.twig', [
            'walkerEmotion' => $walkerEmotion,
            'guessedEmotion' => $answer->getGuessedEmotion(),
            'score' => $score,
        ]);
    }
}
