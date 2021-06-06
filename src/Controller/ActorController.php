<?php

namespace App\Controller;
// add if you want use class actor
use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
//use if you want object "response"
use Symfony\Component\HttpFoundation\Response;
// add if you want extends abstractcontroller
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use if you want use annotation in route
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    public function __construct(){
        date_default_timezone_set("Europe/Madrid");
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $actors = $this->getDoctrine()->getRepository(Actor::class)->findAll();
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('actor/index.html.twig', [
            'actors' => $actors,
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/{id}",requirements={"id"="\d+"}, methods={"GET"}, name="show")
     */
    public function show(Actor $actor): Response
    {
        return $this->render('actor/show.html.twig', [
            'actor' => $actor 
        ]);
    }
}