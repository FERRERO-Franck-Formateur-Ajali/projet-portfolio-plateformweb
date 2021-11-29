<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\EventSubscriber
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\EventSubscriber;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\EventSubscriber
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\EventSubscriber
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    /**
     * Variable $this->defaultLocale.
     *
     * @var string
     */
    private $defaultLocale;

    private $timeZone;

    /**
     * Void __construct().
     *
     * @param string $defaultLocale comment
     */
    public function __construct(string $defaultLocale, string $timeZone)
    {
        $this->defaultLocale = $defaultLocale;
        $this->timeZone = $timeZone;
    }

    /**
     * Kernel request.
     *
     * @param RequestEvent $event comment
     *
     * @return void
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // essaye de voir si les paramètres régionaux ont été définis comme paramètre de routage _locale
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            // si aucune locale explicite n'a été définie sur cette demande, on utilise la session et la langue par défaut
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }

        if (null === $request->getSession()->get('timezone')) {
            date_default_timezone_set($this->timeZone);
        } else {
            date_default_timezone_set($request->getSession()->get('timezone'));
        }
    }

    /**
     * Enregistrement du KernelEvents.
     *
     * @return void
     */
    public static function getSubscribedEvents()
    {
        return [
            // doit être enregistré avant (c'est-à-dire avec une priorité plus élevée que) l'écouteur de paramètres régionaux par défaut
            KernelEvents::REQUEST => [['onKernelRequest', 1]],
        ];
    }
}
