<?php

declare(strict_types=1);

namespace Authentication\Handler;

use App\Factory\SessionFactory;
use Aura\Session\Segment;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;

class Register implements RequestHandlerInterface
{
    private TemplateRendererInterface $renderer;
    private UrlHelper $urlHelper;

    public function __construct(TemplateRendererInterface $renderer, UrlHelper $urlHelper)
    {
        $this->renderer  = $renderer;
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getMethod() === 'POST') {
            $session = $request->getAttribute(SessionFactory::APP);
            assert($session instanceof Segment);
            $session->set('loggedIn', true);

            return new RedirectResponse($this->urlHelper->generate('authentication.myprofile'));
        }

        return new HtmlResponse($this->renderer->render(
            'authentication::register',
            [] // parameters to pass to template
        ));
    }
}
