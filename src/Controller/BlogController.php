<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $blogRepository): Response
    {

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'blogs' => $blogRepository->findBy(['is_published' => true], ['creat_at' => 'desc'], 6),
        ]);
    }
}
