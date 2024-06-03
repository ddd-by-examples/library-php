<?php

declare(strict_types=1);

namespace Akondas\Library\Catalogue;

enum BookType: string
{
    case RESTRICTED = 'restricted';
    case CIRCULATING = 'circulating';
}
