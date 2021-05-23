<?php

declare(strict_types=1);

namespace App\View\Helper;

use App\Factory\SessionFactory;
use Psr\Container\ContainerInterface;

class FlashMessengerFactory
{
    public function __invoke(ContainerInterface $container): FlashMessenger
    {
        return new FlashMessenger($container->get('session')->getSegment(SessionFactory::FLASH));
    }
}
