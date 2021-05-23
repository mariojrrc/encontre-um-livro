<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class RouteError extends Exception implements IgnoreErrorPropagation
{
    public static function notFound(): self
    {
        return new self('Route not found', 404);
    }
}
