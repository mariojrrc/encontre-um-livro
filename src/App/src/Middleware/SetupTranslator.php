<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Validator\Translator\Translator;
use Aura\Session\Segment;
use Laminas\I18n\Translator\Translator as I18nTranslator;
use Laminas\Validator\AbstractValidator;
use Locale;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as DelegateInterface;

use function getenv;

class SetupTranslator implements MiddlewareInterface
{
    private Segment $session;
    private I18nTranslator $i18nTranslator;

    public function __construct(Segment $session, I18nTranslator $i18nTranslator)
    {
        $this->session        = $session;
        $this->i18nTranslator = $i18nTranslator;
    }

    public function process(Request $request, DelegateInterface $handler): Response
    {
        $language = $this->session->get('language', getenv('DEFAULT_LANGUAGE'));

        self::withLanguage($this->i18nTranslator, $language);

        if (empty($this->session->get('language', null))) {
            $this->session->set('language', $language);
        }

        $request = $request->withAttribute('translator', $this->i18nTranslator);
        $request = $request->withAttribute('language', $language);

        return $handler->handle($request);
    }

    public static function withLanguage(I18nTranslator $i18nTranslator, string $language): void
    {
        $i18nTranslator->setLocale($language);

        $translator = new Translator();
        $translator->setTranslator($i18nTranslator);

        Locale::setDefault($language);
        AbstractValidator::setDefaultTranslator($translator);
    }
}
