<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

use MyCLabs\Enum\Enum;

/**
 * @method static PatronType regular()
 * @method static PatronType researcher()
 *
 * @psalm-immutable
 */
final class PatronType extends Enum
{
    private const regular = 'regular';
    private const researcher = 'researcher';
}
