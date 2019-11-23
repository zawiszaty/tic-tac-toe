<?php

declare(strict_types=1);

namespace App\UI\Action\Move;

use App\Domain\ValueObject\SelectedField;

final class MoveLeftAction implements MoveActionInterface
{
    public function move(SelectedField $selectedField): SelectedField
    {
        if ($selectedField->getX() - 1 >= 0) {
            $x = $selectedField->getX() - 1;

            return new SelectedField($x, $selectedField->getY());
        }

        throw MoveException::fromCannotMove();
    }
}
