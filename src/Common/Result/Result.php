<?php

declare(strict_types=1);

namespace Akondas\Library\Common\Result;

enum Result: string
{
    case SUCCESS = 'success';
    case REJECTION = 'rejection';
}
