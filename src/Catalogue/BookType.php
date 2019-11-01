<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use MyCLabs\Enum\Enum;

/**
 * @method static self restricted()
 * @method static self circulating()
 */
final class BookType extends Enum
{
    private const restricted = 'restricted';
    private const circulating = 'circulating';
}
