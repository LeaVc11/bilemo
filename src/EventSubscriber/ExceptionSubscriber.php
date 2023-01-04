<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    //il y a 2 méthodes

// c'es tce qu'on va faire qd on écoutes une de ces exceptions
    public function onKernelException(ExceptionEvent $event): void
    {
        //$execption = je récupère ecxeption qui est liée à l'événement
        $exception = $event->getThrowable();

        //je regarde si l'exception est une instance de httpException
        if ($exception instanceof HttpException){
            $data = [
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];
        } else {
            $data = [
                'status' => 500, // Le status n'existe pas car ce n'est pas une exception HTTP, donc on met 500 par défaut.
                'message' => $exception->getMessage()
            ];
        }
        $event->setResponse(new JsonResponse($data));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            //ce qu'on entrain d'écouter
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
