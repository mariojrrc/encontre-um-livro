<?php

declare(strict_types=1);

namespace App\Middleware;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

use function array_key_exists;

class ErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container): ErrorResponseGenerator
    {
        $config = $container->has('config') ? $container->get('config') : [];

        $debug = $config['debug'] ?? false;

        $errorHandlerConfig = $config['mezzio']['error_handler'] ?? [];

        $template = $errorHandlerConfig['template_error'] ?? ErrorResponseGenerator::TEMPLATE_DEFAULT;
        $layout   = array_key_exists('layout', $errorHandlerConfig)
            ? (string) $errorHandlerConfig['layout']
            : ErrorResponseGenerator::LAYOUT_DEFAULT;

        $renderer = $container->get(TemplateRendererInterface::class);

        return new ErrorResponseGenerator($debug, $renderer, $template, $layout);
    }
}
