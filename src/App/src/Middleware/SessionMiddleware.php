<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Factory\SessionFactory;
use App\View\Helper\FlashMessenger;
use Aura\Session\Session;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as DelegateInterface;

// Fixme create sesion service
class SessionMiddleware implements MiddlewareInterface
{
    private Session $session;
    private FlashMessenger $flashMessenger;

    public function __construct(Session $session, FlashMessenger $flashMessenger)
    {
        $this->session        = $session;
        $this->flashMessenger = $flashMessenger;
    }

    public function process(Request $request, DelegateInterface $handler): Response
    {
        $request = $request->withAttribute(SessionFactory::FLASH, $this->flashMessenger);
        $request = $request->withAttribute(SessionFactory::APP, $this->session->getSegment(SessionFactory::APP));

        return $handler->handle($request);
    }
}
