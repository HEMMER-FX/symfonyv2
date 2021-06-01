<?php

namespace App\Controller;

use App\Form\ProgramType;
use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\Program;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormTypeInterface;
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
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        //création nouveau objet program
        $program = new Program();

        // création de formulaire pour utiliser l'entité program
        $form = $this->createForm(ProgramType::class, $program);

        //envoyer le program a la http foundation method
        $form->handleRequest($request);
        
        //si bouton pressé
        if($form->isSubmitted()){
            
            //faire la conenxion avec bdd
            $entityManager = $this->getDoctrine()->getManager();

            // persist form donnée
            $entityManager->persist($program);

            $entityManager->flush();

            return $this->redirectToRoute('program_programs_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form->createView()
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

    /**
     * @Route("/{program}/season/{season}/episode/{episode}",  methods={"GET"}, name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        $season = $program->getSeasons();
        return $this->render('episodes/show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episode
        ]);
    }

}