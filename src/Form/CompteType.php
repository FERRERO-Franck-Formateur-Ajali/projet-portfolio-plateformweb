<?php

namespace App\Form;

use App\Entity\Civility;
use App\Entity\Compte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Télephone',
                'constraints' => [
                    new Length([
                        'max' => 14,
                        'maxMessage' => 'Le champ ne peut pas dépasser 14 caractère',
                    ]),
                    new Regex([
                        'pattern' => '/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/',
                        'match' => true,
                        'message' => 'Veuillez entrer un numéro valide',
                    ]),
                ],
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('codepostal', TextType::class, [
                'label' => 'Code Postal',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'match' => true,
                        'message' => 'Champ invalide',
                    ]),
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('raisonsocial', TextType::class, [
                'label' => 'Raison Social',
                'required' => false,
            ])
            ->add('siret', TextType::class, [
                'label' => 'Siret',
                'required' => false,
            ])
            ->add('fonction', TextType::class, [
                'label' => 'Fonction',
                'required' => false,
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Avatar',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'La taille de l\'image doit être de 1M',
                    ]),
                ],
            ])
            ->add('departement', TextType::class, [
                'label' => 'Département',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 3,
                        'maxMessage' => 'Le champ ne peut pas dépasser 3 caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'match' => true,
                        'message' => 'Champ invalide',
                    ]),
                ],
            ])
            ->add('lat', TextType::class, [
                'label' => 'Latitude',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',
                        'match' => true,
                        'message' => 'Champ invalide',
                    ]),
                ],
            ])
            ->add('lng', TextType::class, [
                'label' => 'Longitude',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',
                        'match' => true,
                        'message' => 'Champ invalide',
                    ]),
                ],
            ])
            ->add('civility', EntityType::class, [
                'class' => Civility::class,
                'choice_label' => 'civilite',
                'choice_value' => 'id',
                'label' => 'Civilité',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
