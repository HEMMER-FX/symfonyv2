<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{

    /**
     * @Route("/programs/{page}", requirements={"page"="\d+"}, methods={"GET"},name="program_show")
    */
    public function show(int $page): Response
    {
        return $this->render('program/show.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/programs/", name="test_program")
     */
    public function test(): Response
    {
        $request = Request::createFromGlobals();

        $programe = $request->query->get('programs',null);
        return $this->render('program/index.html.twig', ['Programs_demande' => $programe]);
    }
}
