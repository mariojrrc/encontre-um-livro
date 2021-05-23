<?php

declare(strict_types=1);

namespace App\Middleware;

use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as DelegateInterface;
use Throwable;

use function assert;
use function extension_loaded;

class NewRelicMiddleware implements MiddlewareInterface
{
    private string $appName;

    public function __construct(string $appName)
    {
        $this->appName = $appName;
    }

    public static function reportError(Throwable $throwable): void
    {
        if (! extension_loaded('newrelic')) {
            return;
        }

        // phpcs:ignore SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFallbackGlobalName
        newrelic_notice_error($throwable->getMessage(), $throwable);
    }

    public function process(Request $request, DelegateInterface $handler): ResponseInterface
    {
        $this->detectTransactionName($request);

        return $handler->handle($request);
    }

    private function detectTransactionName(Request $request): void
    {
        if (! extension_loaded('newrelic')) { // Ensure PHP agent is available
            return;
        }

        // phpcs:ignore SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFallbackGlobalName
        newrelic_set_appname($this->appName);

        $routeResult = $request->getAttribute(RouteResult::class);
        if (! $routeResult) {
            // phpcs:ignore SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFallbackGlobalName
            newrelic_name_transaction($request->getUri()->getPath() ?: '');

            return;
        }

        assert($routeResult instanceof RouteResult);
        if (! $routeResult->getMatchedRoute()) {
            // phpcs:ignore SlevomatCodingStandard.Namespaces.ReferenceUsedNamesOnly.ReferenceViaFallbackGlobalName
            newrelic_name_transaction($request->getUri()->getPath() ?: '');

            return;
        }

        /**
         * @psalm-suppress PossiblyNullReference, PossiblyFalseReference
         */
        newrelic_name_transaction($routeResult->getMatchedRoute()->getPath()); // phpcs:ignore
    }
}
