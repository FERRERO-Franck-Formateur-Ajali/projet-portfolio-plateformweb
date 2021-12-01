<?php

namespace App\Controller;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    /**
     * @Route("/devis", name="devis")
     */
    public function index(): Response
    {
        $form = $this->getParameter('app_root').'/config/devis.form.yaml';
        $form = Yaml::parseFile($form); // yaml::dump
        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'form' => $form,
        ]);
    }
}
