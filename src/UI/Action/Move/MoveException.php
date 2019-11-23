<?php

declare(strict_types=1);

namespace App\UI\Action\Move;

final class MoveException extends \RuntimeException
{
    public static function fromCannotMove(): self
    {
        return new static('Cannot move');
    }
}
