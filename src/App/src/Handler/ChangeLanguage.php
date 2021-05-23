<?php

declare(strict_types=1);

namespace App\Handler;

use App\Factory\SessionFactory;
use Aura\Session\Session;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ChangeLanguage implements RequestHandlerInterface
{
    private UrlHelper $urlHelper;
    private Session $session;

    public function __construct(UrlHelper $urlHelper, Session $session)
    {
        $this->urlHelper = $urlHelper;
        $this->session   = $session;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $segment = $this->session->getSegment(SessionFactory::APP);
        $segment->set('language', $request->getAttribute('language'));

        return new RedirectResponse($this->urlHelper->generate('home'));
    }
}
