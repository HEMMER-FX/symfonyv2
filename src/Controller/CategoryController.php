<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/categories", name="category_")
     */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $category
        ]);
    }

    /**
     * @Route("/{categoryName}", name="show")
     */
    public function show(string $categoryName)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['name'=>$categoryName]);

        $programs = $this->getDoctrine()->getRepository(Program::class)->findBy(
            ['category'=>$category],
            ['id' => 'DESC'],
            3
        );

        if(!$category) {
            return $this->render('category/error.html.twig');
        }
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs
        ]);
    }

    /**
     * @Route("/empty/category", name="empty")
     */
    public function empty()
    {
        return $this->render('category/notfound.html.twig');
    }

}
