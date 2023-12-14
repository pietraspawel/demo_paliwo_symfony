<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Handle 404 Error.
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    /**
     * Class constructor
     *
     * @param UrlGeneratorInterface $router [description]
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Return subscribed exceptions.
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10],
            ]
        ];
    }

    /**
     * If NotFoundHttpException occur redirects to homepage.
     *
     * @param  ExceptionEvent  $event
     */
    public function processException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $url = $this->router->generate('app_home');
        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse(new RedirectResponse($url));
        }
    }
}
