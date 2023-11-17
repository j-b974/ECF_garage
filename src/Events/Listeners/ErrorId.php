<?php

namespace App\Events\Listeners;

use App\Events\Dispatched\ErrorProduits;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ErrorId
{
    public function __construct(private RouterInterface $router ) {}

    // return listeners créer
    public function onErrorId(ErrorProduits $errorId)
    {

        return new RedirectResponse($this->router->generate('error_id'));

    }
}