<?php

namespace App\Controller;

use App\Traits\FormText;
use App\Form\NewSectionType;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DevisController extends AbstractController
{
    use FormText;
    
    private $file;
    private $tableau;

    public function __construct(ParameterBagInterface $params)
    {
        $this->file = $params->get('app_root').'/config/devis.form.yaml';
        $this->tableau = Yaml::parseFile($this->file); // yaml::dump
    }

    /**
     * @Route("/devis", name="devis")
     */
    public function index(): Response
    {
        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'form' => $this->tableau,
        ]);
    }

    /**
     * @Route("/devis/section", name="admin_section")
     */
    public function form(Request $request, ?string $name, ?string $input): Response
    {
        $paragraphes = [];
        foreach ($this->tableau as $paragraphe => $parametres) {
            $paragraphes[$paragraphe] = $parametres['label'];
        } 
    
    
        return $this->render('devis/section.html.twig', [
            'controller_name' => 'DevisController',
            'form' => $this->tableau,
            'paragraphes' => $paragraphes
        ]);
    }

    /**
     * @Route("/devis/section/new", name="admin_new_section")
     */
    public function newSection(Request $request): Response
    {
        $form = $this->createForm(NewSectionType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $section = $request->request->get('new_section')['section'];

            $this->tableau[$this->slug($section, [' ', '-', ',', '.'], ['_', '_', '_', '_'])] = [
                'label' => $section,
                'tabs' => [],
            ];
    
            file_put_contents($this->file, Yaml::dump($this->tableau));
            exec('rm -R var/cache');
    
            return $this->redirectToRoute('admin_section');
        }
        return $this->render('devis/new.section.html.twig', [
            'controller_name' => 'DevisController',
            'form' => $form->createView(),
        ]);
    }
    /**
     * @param string $name nom de la section
     *@Route("/devis/section/name/{name}", name="admin_name_section")
     */
    public function type(string $name): Response
    {
        $inputs = ['text', 'radio', 'textarea', 'datetime-local', 'file', 'number', 'color', 'password', 'email'];

        return $this->render('devis/type.html.twig', [
            'controller_name' => 'DevisController',
            'name' => $name,
            'inputs' => $inputs,
        ]);
    }
   
    /**
     * @param string $name nom de la section
     * @param string $input nom de l'input choisi
     * @Route("/devis/section/name/{name}/{input}", name="admin_input_section")
     */
    public function input(string $name, string $input): Response
    {
        return $this->render('devis/input.html.twig', [
            'controller_name' => 'DevisController',
            'input' => $input,
            'name' => $name,
        ]);
    }
    /**
     * @param string $name nom de la section/
     *@Route("/devis/section/add/name/{name}/{input}", name="admin_add_input_section")
     */
    public function addYaml(Request $request, string $name, string $input): Response
    {
        $inputs = ['text', 'radio', 'textarea', 'datetime-local', 'file', 'number', 'color', 'password', 'email'];

        return $this->render('devis/type.html.twig', [
            'controller_name' => 'DevisController',
            'name' => $name,
            'inputs' => $inputs,
        ]);
    }
}
