<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Distributeurs;
use App\Entity\References;
use App\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomAnnonces', TextType::class, [
                'label' => 'Nom de l\'annonce :'
            ])
            ->add('descriptionAnnonces', TextareaType::class,[
                'label' => 'Description de l\'annonces : '
            ])
            ->add('prixAnnonces', NumberType::class,[
                'label' => 'Prix de l\'annonce : '
            ])
            ->add('imageAnnonces', FileType::class,[
                'label' => 'Image de l\'annonce',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'Aucune image pour cette annonces'
            ])
            ->add('dateAnnonces',DateTimeType::class,[
                'label' => 'Date de dépot de l\'annonce :'
            ])
            ->add('stockAnnonce', CheckboxType::class,[
                'label' => 'Produit en stock'
            ])
            ->add('categories', EntityType::class,[
                'class' => Categories::class,
                'choice_label' => 'nomCategorie',
                'label' => 'Catégorie de l\'annonce',
                'required' => true
            ])
            ->add('regions', EntityType::class,[
                'class' => Regions::class,
                'choice_label' => 'nomRegion',
                'label' => 'Région de l\'annonce',
                'required' => true
            ])
            ->add('numero', ReferenceType::class,[
                'required' => true
            ])
            ->add('distributeurs', EntityType::class,[
                'class' => Distributeurs::class,
                'choice_label' => 'nomDistributeur',
                'label' => 'Selectionnez un ou plusieurs distruteurs',
                'multiple' => true
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
