<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppError;
use Laminas\Stratigility\Utils;
use Mezzio\Response\ErrorResponseGeneratorTrait;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * Replicated class \Mezzio\Middleware\ErrorResponseGenerator but changing how __invoke method works.
 * In the original class it was overriding pre-defined error message. Check line 47.
 */
class ErrorResponseGenerator
{
    use ErrorResponseGeneratorTrait;

    public const TEMPLATE_DEFAULT = 'error::error';
    public const LAYOUT_DEFAULT   = 'layout::default';

    public function __construct(
        bool $isDevelopmentMode,
        TemplateRendererInterface $renderer,
        string $template,
        string $layout
    ) {
        $this->debug    = $isDevelopmentMode;
        $this->renderer = $renderer;
        $this->template = $template;
        $this->layout   = $layout;
    }

    public function __invoke(
        Throwable $e,
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $reason = $response->getReasonPhrase();
        if ($e instanceof AppError) {
            $reason = $e->getMessage();
        }

        $response = $response->withStatus(
            Utils::getStatusCode($e, $response),
            $reason
        );

        return $this->prepareTemplatedResponse(
            $e,
            $this->renderer,
            [
                'response' => $response,
                'request'  => $request,
                'uri'      => (string) $request->getUri(),
                'status'   => $response->getStatusCode(),
                'reason'   => $response->getReasonPhrase(),
                'layout'   => $this->layout,
            ],
            $this->debug,
            $response
        );
    }
}
