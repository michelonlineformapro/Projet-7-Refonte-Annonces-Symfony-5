<?php

namespace App\Controller\Admin;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\Commentaires;
use App\Entity\Distributeurs;
use App\Entity\References;
use App\Entity\Regions;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(AnnoncesCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="img/sf_logo.png" />');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('TABLEAU DE BORD', 'fa fa-home'),

            /*
            MenuItem::section('Annonces'),
            MenuItem::linkToCrud('Anonnces', 'fa fa-list', Annonces::class),
            */
            MenuItem::section('Catégories'),
            MenuItem::linkToCrud('Catégories', 'fa fa-user', Categories::class),

            MenuItem::section('Régions'),
            MenuItem::linkToCrud('Regions', 'fa fa-user', Regions::class),

            MenuItem::section('Distributeurs'),
            MenuItem::linkToCrud('Distributeurs', 'fa fa-user', Distributeurs::class),

            MenuItem::section('Références'),
            MenuItem::linkToCrud('Références', 'fa fa-user', References::class),

            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),

            MenuItem::section('Commentaires'),
            MenuItem::linkToCrud('Commentaires', 'fa fa-user', Commentaires::class),

        ];

    }
}
