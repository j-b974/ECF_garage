<?php

namespace App\Events\Dispatched;

use Symfony\Contracts\EventDispatcher\Event;

class ErrorProduits extends Event
{

    const ERROR_ID_EVENT = 'id.introuvable';

    public function __construct(private int $id){}
    public function getId():int
    {
        return $this->id;
    }

}