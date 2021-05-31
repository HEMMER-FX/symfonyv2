<?php

namespace App\Controller;


use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Program;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route ("/programs", name="program_")
 */
class ProgramController extends AbstractController
{
    /**
     * show all rows from Program's entity
     * @Route("/", name="programs_index")
     * @return Response A response intance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);

    }

    /**
    * Getting a program by id
    *
    * @Route("/show/{id<^[0-9]+$>}", name="show")
    * @return Response
    */
    public function show(Program $program): Response
    {

        if(!$program){
            throw $this->createNotFoundException(
                'No Program with id : ' .$program. 'found in program\'s table.'
            );
        }
        $season = $program->getSeasons();
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $season
        ]);
    }
    /**
     * @Route("/{program}/season/{season}", methods={"GET"} ,name="season_show")
     */

    public function showSeason(Program $program, Season $season)
    {
        $episode = $season->getEpisodes();
        $season = $program->getSeasons();
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season'  => $season,
            'episodes' => $episode
        ]);
    }

}
