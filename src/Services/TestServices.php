<?php


namespace App\Services;


class TestServices
{
    //Creation d'une fonction de message random
    public function getRandomMessage():string{
        //Tableau de message
        $messages = [
            'Votre annonces à bien été publiée!',
            'Votre email a bien été envoyé',
            'Cette est trés populaire'
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }

}