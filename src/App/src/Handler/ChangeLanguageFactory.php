<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Helper\UrlHelper;
use Psr\Container\ContainerInterface;

class ChangeLanguageFactory
{
    public function __invoke(ContainerInterface $container): ChangeLanguage
    {
        return new ChangeLanguage($container->get(UrlHelper::class), $container->get('session'));
    }
}
