<?php

declare(strict_types=1);

namespace App\Listener;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Handler\NewRelicHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

use function assert;
use function extension_loaded;

class LoggingErrorListenerDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback): ErrorHandler
    {
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler('data/logs/error.log', Logger::DEBUG));
        if (extension_loaded('newrelic')) {
            $newRelicLogger = new NewRelicHandler(Logger::WARNING, true, $container->get('config')['newrelic_app_name'], true);
            $newRelicLogger->setFormatter(new NormalizerFormatter());
            $logger->pushHandler($newRelicLogger);
        }

        $listener     = new LoggingErrorListener($logger);
        $errorHandler = $callback();
        assert($errorHandler instanceof ErrorHandler);
        $errorHandler->attachListener($listener);

        return $errorHandler;
    }
}
