<?php

declare(strict_types=1);

namespace App\UI\Action\Move;

use App\Domain\ValueObject\SelectedField;

final class MoveRightAction implements MoveActionInterface
{
    public function move(SelectedField $selectedField): SelectedField
    {
        if ($selectedField->getX() + 1 <= 2) {
            $x = $selectedField->getX() + 1;

            return new SelectedField($x, $selectedField->getY());
        }

        throw MoveException::fromCannotMove();
    }
}
