<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 *
 * @method static PatronType regular()
 * @method static PatronType researcher()
 *
 * @psalm-immutable
 */
final class PatronType extends Enum
{
    public const regular = 'regular';
    public const researcher = 'researcher';
}
