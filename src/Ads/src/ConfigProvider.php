<?php

declare(strict_types=1);

namespace Ads;

use Ads\Handler\AdDetail;
use Ads\Handler\AdList;
use Ads\Handler\Categories;
use Ads\Handler\NewAd;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;

/**
 * The configuration provider for the Ads module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'routes' => $this->getRoutes(),
            ConfigAbstractFactory::class => $this->getConfigAbstract(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories'  => [
                Handler\AdDetail::class => Handler\AdDetailFactory::class,
                Handler\AdList::class => Handler\AdListFactory::class,
                Handler\Categories::class => Handler\CategoriesFactory::class,
                Handler\NewAd::class => Handler\NewAdFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'ads'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    private function getRoutes(): array
    {
        return [
            [
                'name' => 'ad.detail',
                'path' => '/ad/detail/{slug}',
                'middleware' => AdDetail::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
            [
                'name' => 'ads.list',
                'path' => '/ad/list',
                'middleware' => AdList::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
            [
                'name' => 'ads.category',
                'path' => '/ad/category/{category}',
                'middleware' => Categories::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
            [
                'name' => 'ads.new',
                'path' => '/ad/new',
                'middleware' => NewAd::class,
                'allowed_methods' => ['GET', 'POST'],
                'auth_required' => false,
            ],
        ];
    }

    private function getConfigAbstract(): array
    {
        return [];
    }
}
