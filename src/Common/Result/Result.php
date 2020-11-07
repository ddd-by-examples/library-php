<?php

declare(strict_types=1);

namespace Akondas\Library\Common\Result;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 *
 * @method static Result SUCCESS()
 * @method static Result REJECTION()
 */
class Result extends Enum
{
    public const SUCCESS = 'success';
    public const REJECTION = 'rejection';
}
