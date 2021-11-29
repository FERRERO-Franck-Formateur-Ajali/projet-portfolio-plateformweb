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
 * PHP version 7
 *
 * @category App\EventSubscriber
 * @package  UserSessionSubscriber.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

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
class UserSessionSubscriber implements EventSubscriberInterface
{
    /**
     * SessionInterface.
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * CompteRepository.
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Security.
     *
     * @var Security
     */
    private $security;

    /**
     * UrlGeneratorInterface.
     *
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Void __construct().
     *
     * @param SessionInterface      $session        Objet
     * @param UserRepository        $userRepository Objet
     * @param Security              $security       Objet
     * @param UrlGeneratorInterface $urlGenerator   objet
     */
    public function __construct(SessionInterface $session, UserRepository $userRepository, Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Met à jour la session de l'utilisateur
     * Si la session est dépassée l'utilisateur sera déconnecté.
     *
     * @param ControllerEvent $event Objet
     *
     * @return void
     */
    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }

        //dump($controller);

        // Session profil
        if (null !== $this->security->getUser()) {
            $user = $this->userRepository->find($this->security->getUser());

            if ($user) {
                $this->userRepository->updateLastVisit($user);
                dump($user);
            }
        }
    }

    /**
     * Function getSubscribedEvents().
     *
     * @return void
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [['onKernelController', 2]],
        ];
    }
}
