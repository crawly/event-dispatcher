<?php

namespace Crawly\EventDispatcher\Factory;

use Crawly\EventDispatcher\EventDispatcher;
use Crawly\EventDispatcher\Exception\InvalidArgumentException;
use Psr\Container\ContainerInterface;

class EventDispatcherFactory
{
    /**
     * @param ContainerInterface $container
     * @return EventDispatcher
     */
    public function __invoke(ContainerInterface $container)
    {
        $listenersConfig = $this->getListenersConfig($container);

        $eventDispatcher = new EventDispatcher();

        foreach ($listenersConfig as $eventName => $listenerNames) {
            $listenerNames = (array) $listenerNames;

            foreach ($listenerNames as $listenerName) {
                $listener = $container->get($listenerName);

                $eventDispatcher->addListener($eventName, $listener);
            }
        }

        return $eventDispatcher;
    }

    /**
     * @param ContainerInterface $container
     * @return array
     */
    private function getListenersConfig(ContainerInterface $container)
    {
        $config = $container->get('config');

        if (!isset($config['crawly']['event_dispatcher']['listeners'])) {
            throw new InvalidArgumentException(
                'Missing [\'crawly\'][\'event_dispatcher\'][\'listeners\'] key in config'
            );
        }

        $listenersConfig = $config['crawly']['event_dispatcher']['listeners'];

        if (!is_array($listenersConfig)) {
            throw new InvalidArgumentException(sprintf(
                'Listeners config must be array, %s given',
                is_object($listenersConfig) ? get_class($listenersConfig) : gettype($listenersConfig)
            ));
        }

        return $listenersConfig;
    }
}