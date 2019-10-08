<?php

declare(strict_types=1);

namespace Crawly\EventDispatcher;

use Crawly\EventDispatcher\Factory\EventDispatcherFactory;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies() : array
    {
        return [
            'factories' => [
                EventDispatcher::class => EventDispatcherFactory::class,
            ],
        ];
    }
}
