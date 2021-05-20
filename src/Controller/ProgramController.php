<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    protected $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/programs/{page}", requirements={"page"="\d+"}, methods={"GET"},name="program_show")
    */
    public function show(int $page): Response
    {
        return $this->render('program/show.html.twig', ['page' => $page]);
    }

    /**
     * @Route("/programs/{programs</d+>?0}",  name="test_program"), methods={"GET","POST"}
     */
    public function test(Request $request): Response
    {
        $this->logger->error("une demande de programme a était faite");
        $programe = $request->query->get('programs',null);
        return $this->render('program/index.html.twig', ['Programs_demande' => $programe]);
    }
}
