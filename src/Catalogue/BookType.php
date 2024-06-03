<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 *
 * @method static BookType restricted()
 * @method static BookType circulating()
 *
 * @psalm-immutable
 */
final class BookType extends Enum
{
    public const restricted = 'restricted';
    public const circulating = 'circulating';
}
