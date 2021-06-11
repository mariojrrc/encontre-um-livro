<?php

declare(strict_types=1);

namespace Authentication\Handler;

use App\Factory\SessionFactory;
use Aura\Session\Segment;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;

class Logout implements RequestHandlerInterface
{
    private UrlHelper $urlHelper;

    public function __construct(UrlHelper $urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $session = $request->getAttribute(SessionFactory::APP);
        assert($session instanceof Segment);
        $session->set('loggedIn', false);

        return new RedirectResponse($this->urlHelper->generate('home'));
    }
}
