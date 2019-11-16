<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use RuntimeException;

final class MoveException extends RuntimeException
{
    public static function fromCannotMove(string $move): self
    {
        return new static(sprintf('Cannot Move to: %s', $move));
    }
}
