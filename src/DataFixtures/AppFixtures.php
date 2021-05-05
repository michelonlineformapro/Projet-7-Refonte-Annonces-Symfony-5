<?php

namespace App\DataFixtures;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Entity\References;
use App\Entity\Regions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Cache\PredisCache;
use Doctrine\Persistence\ObjectManager;
use Faker;
use PhpParser\Node\Expr\Array_;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $annonces = Array();
        for($i = 0; $i < 100; $i++){
            /*
            //Instance de l'rntité
            $annonces[$i] =  new Annonces();

            $categories = new Categories();
            $regions = new Regions();

            $annonces[$i]->setNomAnnonces($faker->word);
            $annonces[$i]->setDescriptionAnnonces($faker->sentence($nbWords = 20, $variableNbWords = true));
            $annonces[$i]->setPrixAnnonces($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000));
            $annonces[$i]->setImageAnnonces("https://picsum.photos/200/300?grayscale");
            $annonces[$i]->setDateAnnonces($faker->dateTimeAD($max = 'now', $timezone = null));
            $annonces[$i]->setStockAnnonce($faker->boolean);
            $annonces[$i]->setCategories($categories->setNomCategorie($faker->word));
            $annonces[$i]->setRegions($regions->setNomRegion($faker->word));
            */

            $reference = new References();
            $reference->setNumeroReference($faker->randomNumber($nbDigits = NULL, $strict = false));
            $manager->persist($reference);

        }

        $manager->flush();
    }
}
