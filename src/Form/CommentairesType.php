<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Commentaires;
use App\Repository\AnnoncesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('auteurs', TextareaType::class,[
                'label' => 'Nom de auteur'
            ])
            ->add('contenus', TextareaType::class,[
                'label' => 'Message :'
            ])
            ->add('datePoste', DateTimeType::class,[
                'label' => 'Date'
            ])
            ->add('annonces', EntityType::class,[
                'class' => Annonces::class,
                'choice_label' => function(Annonces $annonces){
                return $annonces->getId();
                }
            ])

            ->add('valider', SubmitType::class,[
                'label' => 'Posté le message'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
