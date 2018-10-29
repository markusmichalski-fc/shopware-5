<?php

namespace Shopware\Plugins\MoptPaymentPayone\Subscribers;

use Enlight\Event\SubscriberInterface;

class OrderNumber implements SubscriberInterface
{
    /**
     * di container
     *
     * @var \Shopware\Components\DependencyInjection\Container
     */
    private $container;

    /**
     * inject di container
     *
     * @param \Shopware\Components\DependencyInjection\Container $container
     */
    public function __construct(\Shopware\Components\DependencyInjection\Container $container)
    {
        $this->container = $container;
    }

    /**
     * return array with all subsribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'sOrder::sGetOrderNumber::replace' => 'onGetOrderNumber',
        ];
    }

    public function onGetOrderNumber(\Enlight_Hook_HookArgs $args)
    {
        $session = Shopware()->Session();
        $moptReservedOrdernum = $session->offsetGet('moptReservedOrdernum');
        if (isset($moptReservedOrdernum)) {
            $args->setReturn($moptReservedOrdernum);
        } else {
            // standard behaviour
            $args->setReturn($args->getSubject()->executeParent(
                $args->getMethod(),
                $args->getArgs()
            ));
        }
    }
}