<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Repository\ProjetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetsController extends AbstractController
{
    /**
     * @Route("/portfolio", name="porftfolio")
     */
    public function index(ProjetsRepository $projetsRepository): Response
    {
        return $this->render('projets/index.html.twig', [
            'controller_name' => 'ProjetsController',
            'projets' => $projetsRepository->findAll(9),
        ]);
    }

    /**
     * @Route("/portfolio/{slug}", name="portfolio_full")
     */
    public function full(Projets $projets): Response
    {
        return $this->render('projets/full.html.twig', [
            'projets' => $projets,
        ]);
    }
}
