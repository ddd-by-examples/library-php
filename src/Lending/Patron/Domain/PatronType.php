<?php

declare(strict_types=1);

namespace Akondas\Library\Lending\Patron\Domain;

enum PatronType: string
{
    case REGULAR = 'regular';
    case RESEARCHER = 'researcher';
}
