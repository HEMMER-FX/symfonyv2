<?php

namespace App\Controller;

use App\Entity\Program;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    /**
     * show all rows from Program's entity
     * @Route("/", name="home")
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
    public function show(int $id): Response
    {
        // $program = $programRepository->findOneBy(['id'=>$id]);
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);
        if(!$program){
            throw $this->createNotFoundException(
                'No Program with id : ' .$program. 'found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }
}
