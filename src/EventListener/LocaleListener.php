<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class LocaleListener
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // Récupérer la langue à partir de la session, ou définir 'fr' par défaut
        $lang = $request->getSession()->get('lang', 'fr');

        // Appliquer la locale de la requête
        $request->setLocale($lang);
    }
}
