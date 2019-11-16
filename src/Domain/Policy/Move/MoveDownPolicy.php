<?php

declare(strict_types=1);

namespace App\Domain\Policy\Move;

use App\Domain\Exception\MoveException;
use App\Domain\ValueObject\SelectedField;

final class MoveDownPolicy implements MovePolicyInterface
{
    public function move(SelectedField $selectedField): SelectedField
    {
        if ($selectedField->getY() + 1 <= 2) {
            $y = $selectedField->getY() + 1;

            return new SelectedField($selectedField->getX(), $y);
        }

        throw MoveException::fromCannotMove('down');
    }
}
