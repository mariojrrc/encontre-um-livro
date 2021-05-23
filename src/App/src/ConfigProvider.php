<?php

declare(strict_types=1);

namespace App;

use App\Factory\SessionFactory;
use App\Factory\TranslatorFactory;
use App\Handler\ChangeLanguage;
use App\Handler\HomePageHandler;
use App\Handler\PingHandler;
use Laminas\I18n\Translator\TranslatorInterface;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\View\HelperPluginManager;
use Mezzio\Application;
use Mezzio\Container\ApplicationFactory;
use Mezzio\Container\ErrorHandlerFactory;
use Mezzio\Helper;
use Mezzio\LaminasView\LaminasViewRendererFactory;
use Mezzio\Middleware\ErrorResponseGenerator;
use Mezzio\Template\TemplateRendererInterface;

/**
 * The configuration provider for the App module
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
     *
     * @return array<string,array>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'routes' => $this->getRoutes(),
            ConfigAbstractFactory::class => $this->getConfigAbstract(),
            'view_helpers' => $this->getViewHelpers(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array<string,array>
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Application::class       => ApplicationFactory::class,
                Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
                Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
                Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,

                ErrorResponseGenerator::class => Middleware\ErrorResponseGeneratorFactory::class,
                ErrorHandler::class => ErrorHandlerFactory::class,

                TemplateRendererInterface::class => LaminasViewRendererFactory::class,
                HelperPluginManager::class => View\Helper\HelperPluginManagerFactory::class,
                View\Helper\FlashMessenger::class => View\Helper\FlashMessengerFactory::class,

                'session' => SessionFactory::class,
                'translator' => TranslatorFactory::class,

                TranslatorInterface::class => Factory\TranslatorFactory::class,

                Middleware\SetupTranslator::class => Middleware\SetupTranslatorFactory::class,
                Middleware\SessionMiddleware::class => Middleware\SessionMiddlewareFactory::class,
                Middleware\NewRelicMiddleware::class => Middleware\NewRelicFactory::class,

                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                Handler\ChangeLanguage::class => Handler\ChangeLanguageFactory::class,
            ],
            'delegators' => [
                ErrorHandler::class => [
                    Listener\LoggingErrorListenerDelegatorFactory::class,
                ],
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array<string,array>
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }

    private function getRoutes(): array
    {
        return [
            [
                'name' => 'health',
                'path' => '/health',
                'middleware' => PingHandler::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
            [
                'name' => 'home',
                'path' => '/[home]',
                'middleware' => HomePageHandler::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
            [
                'name' => 'change-language',
                'path' => '/change-language[/{language}]',
                'middleware' => ChangeLanguage::class,
                'allowed_methods' => ['GET'],
                'auth_required' => false,
            ],
        ];
    }

    private function getConfigAbstract(): array
    {
        return [];
    }

    private function getViewHelpers(): array
    {
        return [
            'aliases' => [
                't' => 'translate',
                '_' => 'translate',
            ],
        ];
    }
}
