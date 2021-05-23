<?php

declare(strict_types=1);

namespace App\Helper;

use App\Middleware\NewRelicMiddleware;
use Throwable;

use function getenv;

final class Logger
{
    public static function logFromThrowable(Throwable $throwable): void
    {
        NewRelicMiddleware::reportError($throwable);

        if (getenv('APPLICATION_ENV') !== 'development') {
            return;
        }

        throw $throwable;
    }
}
