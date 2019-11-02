<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use MyCLabs\Enum\Enum;

/**
 * @method static BookType restricted()
 * @method static BookType circulating()
 */
final class BookType extends Enum
{
    private const restricted = 'restricted';
    private const circulating = 'circulating';
}
