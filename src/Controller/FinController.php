<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Enum\WalkerEmotion;
use App\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FinController extends AbstractController
{
    public function __construct(
        private readonly AnswerRepository $answerRepo,
    ) {
    }

    #[Route('/fin/{id}', name: 'fin', methods: ['GET'])]
    public function fin(Answer $answer): Response
    {
        $translateEmotion = static fn (?WalkerEmotion $e) => match ($e) {
            WalkerEmotion::SAD => 'bēdīgs',
            WalkerEmotion::HAPPY => 'priecīgs',
            default => 'nezināms',
        };
        $score = $answer->getThreshold();
        $stats = $this->answerRepo->getStats();
        $currentGuess = [
            'time' => $answer->getThreshold() / 1000,
            'correct' => $answer->getWalkerEmotion() === $answer->getGuessedEmotion(),
        ];

        return $this->render('test/fin.html.twig', [
            'walkerEmotion' => $translateEmotion($answer->getWalkerEmotion()),
            'guessedEmotion' => $translateEmotion($answer->getGuessedEmotion()),
            'score' => $score,
            'stats' => $stats,
            'currentGuess' => $currentGuess,
        ]);
    }
}
