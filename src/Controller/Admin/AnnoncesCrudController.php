<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\DomCrawler\Field\FileFormField;

class AnnoncesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Annonces::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('nomAnnonces', 'Nom annonce'),
            TextEditorField::new('descriptionAnnonces', 'Description annonce'),
            NumberField::new('prixAnnonces', 'Prix annonce'),
            ImageField::new('imageAnnonces')
                ->setBasePath('/img')
                ->setUploadDir('public/img/')
                ->setFormType(FileUploadType::class)
                ->setRequired(false),

            BooleanField::new('stockAnnonce', 'Produit en stock'),
            DateTimeField::new('dateAnnonces', 'Date de depot'),
            AssociationField::new('categories', 'Categories'),
            AssociationField::new('regions', 'Region du vendeur'),
            AssociationField::new('distributeurs', 'Nom du distributeur'),
            AssociationField::new('numero', 'Référence annonce'),
            AssociationField::new('utilisateurs', 'Nom du vendeur')
        ];
    }

}
