<?php

declare(strict_types=1);

namespace App\Domain\Policy\Move;

use App\Domain\ValueObject\SelectedField;

interface MovePolicyInterface
{
    public function move(SelectedField $selectedField): SelectedField;
}
