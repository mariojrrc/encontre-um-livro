<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exception\IgnoreErrorPropagation;
use App\Exception\NotError;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Throwable;

use function sprintf;

class LoggingErrorListener
{
    public const LOG_FORMAT = '%d [%s] %s: %s TRACE => %s';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Throwable $error, Request $request, Response $response): void
    {
        if ($error instanceof IgnoreErrorPropagation) {
            return;
        }

        $message = $error->getMessage();

        $severity = 'error';
        if ($error instanceof NotError) {
            // This will save the error in the log file but not NewRelic
            $severity = 'notice';
        }

        $this->logger->$severity(sprintf(
            self::LOG_FORMAT,
            $response->getStatusCode(),
            $request->getMethod(),
            (string) $request->getUri(),
            $message,
            $error->getTraceAsString()
        ), ['exception' => $error]);
    }
}
