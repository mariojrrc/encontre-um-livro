<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Factory\SessionFactory;
use Psr\Container\ContainerInterface;

class SetupTranslatorFactory
{
    public function __invoke(ContainerInterface $container): SetupTranslator
    {
        return new SetupTranslator($container->get('session')->getSegment(SessionFactory::APP), $container->get('translator'));
    }
}
