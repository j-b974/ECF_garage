<?php
namespace App\Repository;
use \PDO;
class DataBaseGarage
{
    public static function connection() : PDO
    {

        return new PDO($_ENV['GARAGE_DATABASE_URL'],$_ENV['GARAGE_DATABASE_USER'],$_ENV['GARAGE_DATABASE_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
    }
}