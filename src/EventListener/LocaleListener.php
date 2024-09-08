<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleListener
{
    private $defaultLocale;

    public function __construct(string $defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        // Vérifiez si une locale est spécifiée dans l'URL
        if ($locale = $request->attributes->get('_locale')) {
            $session->set('_locale', $locale);
            $request->setLocale($locale);
        } elseif ($sessionLocale = $session->get('_locale')) {
            // Si aucune locale n'est spécifiée dans l'URL, utilisez celle de la session
            $request->setLocale($sessionLocale);
        } else {
            // Utilisez la locale par défaut si aucune n'est trouvée
            $request->setLocale($this->defaultLocale);
        }
    }
}
