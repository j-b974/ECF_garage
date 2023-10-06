<?php
namespace App\Repository;
use \PDO;
use Symfony\Component\Dotenv\Dotenv;
class DataBaseGarage
{
    public static function connection() : PDO
    {

        if(empty($_ENV)) {
            self::initEnvSymfony();
        }
        return new PDO($_ENV['GARAGE_DATABASE_URL'],$_ENV['GARAGE_DATABASE_USER'],$_ENV['GARAGE_DATABASE_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
    }
    private static function initEnvSymfony()
    {
        // Chargez les variables d'environnement du fichier .env
        $dotenv = new Dotenv();
        $dotenv->loadEnv(dirname(__DIR__,2).'\.env');
    }
}