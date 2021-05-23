<?php

declare(strict_types=1);

namespace App\Validator\Translator;

use App\Exception\AppError;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorInterface as I18nTranslator;
use Laminas\Validator\Translator\TranslatorInterface;

use function _;

class Translator implements TranslatorAwareInterface, TranslatorInterface
{
    private ?I18nTranslator $translator  = null;
    private bool $translatorEnabled      = true;
    private string $translatorTextDomain = 'default';

    /**
     * @inheritDoc
     */
    public function translate($message, $textDomain = 'default', $locale = null)
    {
        if ($this->translator === null) {
            throw new AppError(_('Translator not defined'));
        }

        return $this->translator->translate($message, $textDomain, $locale);
    }

    /**
     * @inheritDoc
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @inheritDoc
     */
    public function setTranslator(?I18nTranslator $translator = null, $textDomain = null)
    {
        $this->translator = $translator;

        if ($textDomain !== null) {
            $this->setTranslatorTextDomain($textDomain);
        }

        return $this;
    }

    public function hasTranslator(): bool
    {
        return $this->translator !== null;
    }

    public function isTranslatorEnabled(): bool
    {
        return $this->translatorEnabled;
    }

    /**
     * @inheritDoc
     */
    public function setTranslatorEnabled($enabled = true)
    {
        $this->translatorEnabled = $enabled;

        return $this;
    }

    public function getTranslatorTextDomain(): string
    {
        return $this->translatorTextDomain;
    }

    /**
     * @inheritDoc
     */
    public function setTranslatorTextDomain($textDomain = 'default')
    {
        $this->translatorTextDomain = $textDomain;

        return $this;
    }
}
