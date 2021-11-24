<?php

namespace App\Form;

use App\Entity\Civility;
use App\Entity\Compte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

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
                ],
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('codepostal', TextType::class, [
                'label' => 'Code Postal',
                'required' => false,
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
            ->add('avatar', TextType::class, [
                'label' => 'Avatar',
                'required' => false,
            ])
            ->add('departement', TextType::class, [
                'label' => 'Département',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 3,
                        'maxMessage' => 'Le champ ne peut pas dépasser 3 caractères.',
                    ]),
                ],
            ])
            ->add('lat', TextType::class, [
                'label' => 'Latitude',
                'required' => false,
            ])
            ->add('lng', TextType::class, [
                'label' => 'Longitude',
                'required' => false,
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
