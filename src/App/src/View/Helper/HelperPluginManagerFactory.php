<?php

declare(strict_types=1);

namespace App\View\Helper;

use Laminas\Form\ConfigProvider as FormConfigProvider;
use Laminas\I18n\ConfigProvider as I18nConfigProvider;
use Laminas\View\HelperPluginManager;
use Psr\Container\ContainerInterface;

class HelperPluginManagerFactory
{
    public function __invoke(ContainerInterface $container): HelperPluginManager
    {
        $config = $container->has('config') ? $container->get('config') : [];
        $config = $config['view_helpers'] ?? [];

        /**
         * @psalm-suppress ArgumentTypeCoercion
         */
        $manager = new HelperPluginManager($container); // @phpstan-ignore-line

        $manager->configure((new FormConfigProvider())->getViewHelperConfig());
        $manager->configure((new I18nConfigProvider())->getViewHelperConfig());
        $manager->configure($config);

        return $manager;
    }
}
