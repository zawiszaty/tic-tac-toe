<?php

declare(strict_types=1);

namespace App\UI\Action\Move;

use App\Domain\ValueObject\SelectedField;

interface MoveActionInterface
{
    public function move(SelectedField $selectedField): SelectedField;
}
