<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class TimeZoneSubscriber implements EventSubscriberInterface
{
    /**
     * Variable $this->defaultTimezone.
     *
     * @var string
     */
    private $defaultTimezone;

    /**
     * Void __construct().
     *
     * @param string $defaultTimezone comment
     */
    public function __construct(string $defaultTimezone)
    {
        $this->defaultTimezone = $defaultTimezone;
    }

    /**
     * Function onKernelRequest.
     *
     * @param RequestEvent $event comment
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // TimeZone
        if ($request->getSession()->get('timezone') !== null) {
            date_default_timezone_set($request->getSession()->get('timezone'));
        } else {
            date_default_timezone_set($this->defaultTimezone);
        }
    }

    /**
     * Static getSubscribedEvents().
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
