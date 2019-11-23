<?php

declare(strict_types=1);

namespace App\Infrastructure;

final class BoardNotFoundException extends \Exception
{
    public static function fromMissingBoard(): self
    {
        return new static('Board Not Found');
    }
}
