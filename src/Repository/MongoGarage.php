<?php


namespace App\Repository;
require_once(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');


class MongoGarage
{
    /**
     * @return mongoDataBase
     */
    public static function connection()
    {
        // root => utilisateur ; examjple => mdp , ; port
        $uri = 'mongodb://root:example@mongo:27017/';

        // Create a new client and connect to the server
        $client = new \MongoDB\Client($uri);

        // crée ou selecte la database
        return $client->Garagedb;
    }
}