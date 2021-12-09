<?php

namespace App\Controller;

use Dompdf\Dompdf;
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
     * Affiche le formulaire dévis au client
     * 
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
     * En admin
     * Ajoute une nouvelle section au questionnaire du devis 
     * 
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
     * En admin
     * 
     * @param string $section nom de la section
     * @param string|null $input nom de l'input choisi
     * 
     * @Route("/devis/section/name/{section}", name="admin_name_section")
     * @Route("/devis/section/name/{section}/{input}", name="admin_input_section")
     * @Route("/devis/section/name/{section}/{input}/add", name="admin_add_input_yaml")
     */
    public function addYaml(Request $request, string $section, ?string $input): Response
    {

        if ($request->request->get('token') !== null && $section && $input) {
            $request->request->remove('token');
            $question = $request->request->get('question');
            $help = $request->request->get('help');
            $type = $input;
            $slug = $this->slug($question);
            $placeholder = $request->request->get('placeholder');
            $options = [];
            if($input === 'radio' || $input === 'select' || $input === 'multicheckbox'){
                $labels = $request->request->get('label');
                $values = $request->request->get('value');
                
                for($i = 0; $i < count($labels); $i++) {
                    $options[]=[
                    'label' => $labels[$i],
                    'value' => $values[$i],
                    ];
                }
            }
            $tabs = [
                'label' => $question,
                'type' => $type,
                'help' => $help,
                'slug' => $slug,
                'placeholder' => $placeholder,
            ];
            if(!empty($options)){
                $tabs['options'] = $options;
            }

            $this->tableau[$section]['tabs'][] = $tabs;

            

            file_put_contents($this->file, Yaml::dump($this->tableau));
            exec('rm -R var/cache');
            
            
        }

        $paragraphes = [];
        foreach ($this->tableau as $paragraphe => $parametres) {
            $paragraphes[$paragraphe] = $parametres['label'];
        } 

        $inputs = ['text', 'select', 'radio', 'textarea', 'datetime-local', 'file', 'number', 'color', 'password', 'email', 'checkbox', 'multicheckbox'];

        return $this->render('devis/form.html.twig', [
            'controller_name' => 'DevisController',
            'section' => $section,
            'inputs' => $inputs,
            'input' => $input,
            'paragraphes' => $paragraphes
        ]);
    }
    # Sert à récupérer les informations personnelles
    /**
     * @Route("/devis/connexion", name="connexion")
     */
    public function connectionAction(Request $request) 
    {
        $devis = [];
        if($this->getUser()){
            $devis['client'] = [
                'nom' => $this->getUser()->getCompte()->getName(),
                'prenom' => $this->getUser()->getCompte()->getFirstName(),
                'email' =>  $this->getUser()->getEmail(),
                'societe' => '',
                'denomination' => '',
                'siret' => '',
            ];
        }else{
            $devis['client'] = [
                'nom' => $request->request->get('nom'),
                'prenom' => $request->request->get('prenom'),
                'email' => $request->request->get('email'),
                'societe' => $request->request->get('societe'),
                'denomination' => $request->request->get('denomination'),
                'siret' => $request->request->get('siret'),
            ];

            $request->request->remove('nom');
            $request->request->remove('prenom');
            $request->request->remove('email');
            $request->request->remove('societe');
            $request->request->remove('denomination');
            $request->request->remove('siret');
        }
        
        $devis['devis'] = [];
        foreach ($request->request as $key => $value){
            array_push($devis['devis'],$value);
        }
        /*
        $template = $this->renderView('devis/layout/layout1.html.twig', [
            'sitename' => 'plateformweb',

        ]);*/
        // instantiate and use the dompdf class
        /*$dompdf = new Dompdf();
        $dompdf->loadHtml($template);

        // (Optional) Setup the paper size and orientationu
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();*/

        return $this->render('devis/layout/layout1.html.twig', [
            'sitename' => 'plateformweb',
            'devis' => $devis,
        ]);
    }
    

}
