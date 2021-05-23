<?php

declare(strict_types=1);

namespace App;

use function _;

class Constants
{
    public const CATEGORY_EDUCACAO_INFANTIL = 'educacao-infantil';
    public const CATEGORY_FUNDAMENTAL_I     = 'fundamental-1';
    public const CATEGORY_FUNDAMENTAL_II    = 'fundamental-2';
    public const CATEGORY_ENSINO_MEDIO      = 'ensino-medio';
    public const CATEGORY_EJA               = 'eja';

    public static function categoryName(string $slug): string
    {
        return self::getCategoriesDescriptions()[$slug] ?? _('Unknown');
    }

    public static function getCategoriesDescriptions(): array
    {
        return [
            self::CATEGORY_EDUCACAO_INFANTIL => _('Children Education'),
            self::CATEGORY_FUNDAMENTAL_I => _('Elementary School I'),
            self::CATEGORY_FUNDAMENTAL_II => _('Elementary School II'),
            self::CATEGORY_ENSINO_MEDIO => _('High School'),
            self::CATEGORY_EJA => _('EJA'),
        ];
    }
}
