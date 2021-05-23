<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\I18n\Translator\Translator as I18nTranslator;
use Psr\Container\ContainerInterface;

use function getenv;

class TranslatorFactory
{
    public function __invoke(ContainerInterface $container): I18nTranslator
    {
        $portalSession = $container->get('session')->getSegment(SessionFactory::APP);
        $language      = $portalSession->get('language', getenv('DEFAULT_LANGUAGE'));

        if ($language === 'en') {
            $language = 'en_US';
        }

        $translator = new I18nTranslator();
        $translator->setLocale($language);
        $translator->addTranslationFilePattern(
            'gettext',
            'data/i18n',
            '%s.mo',
            'default'
        );
        $translator->addTranslationFile(
            'phparray',
            'vendor/laminas/laminas-i18n-resources/languages/pt_BR/Laminas_Validate.php',
            'default',
            'pt_BR'
        );

        return $translator;
    }
}
