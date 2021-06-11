<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Handler\Login;
use Authentication\Handler\Logout;
use Authentication\Handler\MyProfile;
use Authentication\Handler\Register;

/**
 * The configuration provider for the Authentication module
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
            'routes'       => $this->getRoutes(),
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
                Handler\Login::class => Handler\LoginFactory::class,
                Handler\Logout::class => Handler\LogoutFactory::class,
                Handler\MyProfile::class => Handler\MyProfileFactory::class,
                Handler\Register::class => Handler\RegisterFactory::class,
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
                'authentication'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }

    private function getRoutes(): array
    {
        return [
            [
                'name' => 'authentication.login',
                'path' => '/login',
                'middleware' => Login::class,
                'allowed_methods' => ['GET', 'POST'],
                'auth_required' => false,
            ],
            [
                'name' => 'authentication.register',
                'path' => '/register',
                'middleware' => Register::class,
                'allowed_methods' => ['GET', 'POST'],
                'auth_required' => false,
            ],
            [
                'name' => 'authentication.myprofile',
                'path' => '/my-profile',
                'middleware' => MyProfile::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
            [
                'name' => 'authentication.logout',
                'path' => '/logout',
                'middleware' => Logout::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
        ];
    }
}
