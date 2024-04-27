<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Test;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;


class ExportAction extends AbstractController
{
    #[Route('/export/{id}', name: 'app_export', methods: 'GET')]
    public function index(Test $test): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $answers = array_reduce(
            $test->getAnswers()->toArray(),
            static fn($carry, Answer $answer) => [
                ...$carry,
                [
                    $answer->getGender()?->value,
                    $answer->getAge(),
                    $answer->getEducation()?->value,
                    implode(', ', array_map(static fn($hobby) => $hobby->value, $answer->getHobbies())),
                    $answer->getIsMobile() ? 'Jā' : 'Nē',
                    $answer->getThreshold(),
                    $answer->getWalkerEmotion()?->translated(),
                    $answer->getGuessedEmotion()?->translated(),
                    implode(', ', array_map(static fn($em) => "{$em['emotion']}: {$em['intensity']}", $answer->getGewEmotions())),
                    $answer->getCustomEmotion(),
                ]
            ],
            []
        );

        $data = [
            [
                'Dzimums',
                'Vecums',
                'Izglītība',
                'Hobiji',
                'Izmantots viedtalrunis',
                'Emocijas atpazīšanas ātrums (ms)',
                'Stimula emocija',
                'Minētā emocija',
                'Emociju apļa emocijas',
                'Emociju apļa cita emocija',
            ],
            ...$answers,
        ];

        $sheet->fromArray($data);
        $writer = new Writer\Xls($spreadsheet);

        $response = new StreamedResponse(
            fn() => $writer->save('php://output')
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="export.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }
}
