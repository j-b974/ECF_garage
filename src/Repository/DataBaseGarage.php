<?php
namespace App\Repository;
use \PDO;
class DataBaseGarage
{
    public static function connection() : PDO
    {
        return new PDO('mysql:host=localhost;dbname=ecfgarage','root','',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
    }
}