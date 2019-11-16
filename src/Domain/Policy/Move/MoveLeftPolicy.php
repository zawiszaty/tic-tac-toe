<?php

declare(strict_types=1);

namespace App\Domain\Policy\Move;

use App\Domain\Exception\MoveException;
use App\Domain\ValueObject\SelectedField;

final class MoveLeftPolicy implements MovePolicyInterface
{
    public function move(SelectedField $selectedField): SelectedField
    {
        if ($selectedField->getX() - 1 >= 0) {
            $x = $selectedField->getX() - 1;

            return new SelectedField($x, $selectedField->getY());
        }

        throw MoveException::fromCannotMove('left');
    }
}
