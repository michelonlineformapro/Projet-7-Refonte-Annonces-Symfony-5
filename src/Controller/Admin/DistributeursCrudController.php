<?php

namespace App\Controller\Admin;

use App\Entity\Distributeurs;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DistributeursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Distributeurs::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
