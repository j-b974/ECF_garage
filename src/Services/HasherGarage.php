<?php

namespace App\Services;

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\DependencyInjection\ContainerInterface;


class HasherGarage
{

    public static function hashUser()
    {
        return new UserPasswordHasher(new PasswordHasherFactory( [
          "Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface" => [
                "algorithm" => "auto",
                "migrate_from" => [],
                "hash_algorithm" => "sha512",
                "key_length" => 40,
                "ignore_case" => false,
                "encode_as_base64" => true,
                "iterations" => 5000,
                "cost" => null,
                "memory_cost" => null,
                "time_cost" => null,
              ]
        ]));
    }
}