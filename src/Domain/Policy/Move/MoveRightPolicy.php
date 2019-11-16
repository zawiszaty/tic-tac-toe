<?php

declare(strict_types=1);

namespace App\Domain\Policy\Move;

use App\Domain\Exception\MoveException;
use App\Domain\ValueObject\SelectedField;

final class MoveRightPolicy implements MovePolicyInterface
{
    public function move(SelectedField $selectedField): SelectedField
    {
        if ($selectedField->getX() + 1 <= 2) {
            $x = $selectedField->getX() + 1;

            return new SelectedField($x, $selectedField->getY());
        }

        throw MoveException::fromCannotMove('right');
    }
}
