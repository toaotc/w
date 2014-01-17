<?php

namespace Toa\Bundle\MiscBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;

/**
 * RecycleAttributesListener
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class RecycleAttributesListener implements EventSubscriberInterface
{
    private $attributeNames;
    private $router;
    private $requestStack;

    /**
     * RequestStack will become required in 3.0.
     */
    public function __construct($attributeNames = null, RequestContextAwareInterface $router = null, RequestStack $requestStack = null)
    {
        $this->attributeNames = $attributeNames;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (null === $this->attributeNames) {
            return;
        }

        $request = $event->getRequest();

        foreach ($this->attributeNames as $attributeName) {
            $this->setRouterContext($request, $attributeName);
        }
    }

    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        if (null === $this->requestStack) {
            return; // removed when requestStack is required
        }

        if (null === $this->attributeNames) {
            return;
        }

        if (null !== $parentRequest = $this->requestStack->getParentRequest()) {
            foreach ($this->attributeNames as $attributeName) {
                $this->setRouterContext($parentRequest, $attributeName);
            }
        }
    }

    private function setRouterContext(Request $request, $attributeName)
    {
        if (null !== $this->router) {
            if ($attr = $request->attributes->get($attributeName)) {
                $this->router->getContext()->setParameter($attributeName, $attr);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the Router to have access to the _locale
            KernelEvents::REQUEST => array(array('onKernelRequest', 16)),
            KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
        );
    }
}
