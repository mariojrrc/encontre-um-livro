<?php

declare(strict_types=1);

namespace Authentication\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class MyProfileFactory
{
    public function __invoke(ContainerInterface $container): MyProfile
    {
        return new MyProfile($container->get(TemplateRendererInterface::class));
    }
}
