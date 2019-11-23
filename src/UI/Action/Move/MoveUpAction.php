<?php

declare(strict_types=1);

namespace App\UI\Action\Move;

use App\Domain\ValueObject\SelectedField;

final class MoveUpAction implements MoveActionInterface
{
    public function move(SelectedField $selectedField): SelectedField
    {
        if ($selectedField->getY() - 1 >= 0) {
            $y = $selectedField->getY() - 1;

            return new SelectedField($selectedField->getX(), $y);
        }

        throw MoveException::fromCannotMove();
    }
}
