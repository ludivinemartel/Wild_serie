<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
         ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(int $id, ProgramRepository $programRepository):Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        // same as $program = $programRepository->find($id);
    
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/program/{programId}/seasons/{seasonId}/episodes', name: 'season_show')]
public function showEpisodes(int $programId, int $seasonId, ProgramRepository $programRepository): Response
{
    $program = $programRepository->findOneBy(['id' => $programId]);

    if (!$program) {
        throw $this->createNotFoundException(
            'No program with id : '.$programId.' found in program\'s table.'
        );
    }

    $season = $program->getSeasons()->filter(function ($season) use ($seasonId) {
        return $season->getId() === $seasonId;
    })->first();

    if (!$season) {
        throw $this->createNotFoundException(
            'No season with id : '.$seasonId.' found in program\'s seasons.'
        );
    }

    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
    ]);
}

}
