<?php

declare(strict_types=1);

namespace App\Factory;

use Aura\Session\Session;
use Aura\Session\SessionFactory as AuraSessionFactory;
use Psr\Container\ContainerInterface;

use function ini_set;

class SessionFactory
{
    public const APP   = 'App';
    public const FLASH = 'App\Flash';
    public const AUTH  = 'App\Auth';

    public function __invoke(ContainerInterface $container): Session
    {
        $config = $container->get('config');
        if (isset($config['session']['save_handler']) && $config['session']['save_handler'] === 'redis') {
            ini_set('session.save_handler', 'redis');
            ini_set('session.save_path', $config['session']['save_path']);
        }

        $sessionFactory = new AuraSessionFactory();

        return $sessionFactory->newInstance($_COOKIE);
    }
}
