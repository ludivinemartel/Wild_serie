<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

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
    #[Route('/program/{id}/', name: 'show')]
    public function show(Program $program):Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', ['program' => $program, ]);
    }

    #[Route('/program/{programId}/seasons/{seasonId}', name: 'season_show')]
    public function showSeason(#[MapEntity(id: 'programId')] Program $program, #[MapEntity(id: 'seasonId')]Season $season): Response
{
    return $this->render('program/season_show.html.twig', [
        'program' => $program,
        'season' => $season,
    ]);
}

#[Route('/program/{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show')]
public function showEpisodes(#[MapEntity(id: 'programId')] Program $program, #[MapEntity(id: 'seasonId')]Season $season, #[MapEntity(id: 'episodeId')] Episode $episode): Response
{
    return $this->render('program/episode_show.html.twig', [
        'program' => $program,
        'season' => $season,
        'episode' => $episode,
    ]);
}
}