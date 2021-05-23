<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Mezzio\Application;
use Mezzio\Container\ApplicationConfigInjectionDelegator;

return [
    'newrelic_app_name' => 'encontre-um-livro',
    // Toggle the configuration cache. Set this to boolean false, or remove the
    // directive, to disable configuration caching. Toggling development mode
    // will also disable it by default; clear the configuration cache using
    // `composer clear-config-cache`.
    ConfigAggregator::ENABLE_CACHE => true,

    // Enable debugging; typically used to provide debugging information within templates.
    'debug' => false,

    'mezzio' => [
        // Provide templates for the error handling middleware to use when
        // generating responses.
        'error_handler' => [
            'template_404' => 'error::404',
            'template_error' => 'error::error',
        ],
    ],
    'dependencies' => [
        'abstract_factories' => [
            ConfigAbstractFactory::class,
        ],
        'delegators' => [
            Application::class => [
                ApplicationConfigInjectionDelegator::class,
            ],
        ],
    ],
];
