<?php

namespace App\Events\Listeners;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class Error404
{

    private $router;

    public function __construct(RouterInterface $router)
    {

        $this->router = $router;
    }

    public function onExceptionNotFound(ExceptionEvent $event)
    {
        //dd($event->getThrowable() instanceof  TypeError);
        if ($event->getThrowable() instanceof  NotFoundHttpException) {
            $response = new RedirectResponse($this->router->generate('app_error'));
            $event->setResponse($response);
        }

    }

}