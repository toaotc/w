<?php

namespace Toa\Bundle\MiscBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

/**
 * HostParamsListener
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class HostParamsListener implements EventSubscriberInterface
{
    /** @var RouterInterface */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $context = $this->router->getContext();

        if ($domain = $request->attributes->get('_domain')) {
            $context->setParameter('_domain', $domain);
        }

        if ($subdomain = $request->attributes->get('_subdomain')) {
            $context->setParameter('_subdomain', $subdomain);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array (
            KernelEvents::REQUEST => array(array ('onKernelRequest', 16))
        );
    }
}
