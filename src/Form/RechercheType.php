<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories',EntityType::class,[
                'class' => Categories::class,
                'choice_label' => 'nomCategorie',
                'required' => false
            ])
            ->add('regions', EntityType::class,[
                'class' => Regions::class,
                'choice_label' => 'nomRegion',
                'required' => false
            ])
            ->add('prixAnnonces', NumberType::class,[
                'label'=> 'Votre budget max',
                'required' => false
            ])

            ->add('recherche', SubmitType::class,[
                'label' => 'rechercher'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
