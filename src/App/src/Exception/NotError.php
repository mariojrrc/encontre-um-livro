<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * Prevent the Throwable to be reported to NewRelic changing the severity to NOTICE
 */
interface NotError
{
}
