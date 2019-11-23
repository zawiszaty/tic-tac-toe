<?php

declare(strict_types=1);

namespace App\Infrastructure\Presenter;

use App\Domain\ValueObject\Player;
use App\Domain\ValueObject\SelectedField;

final class BoardView
{
    /** @var array */
    private $entities;

    /** @var SelectedField */
    private $selectedField;

    /** @var Player */
    private $currentPlayer;

    public function __construct(array $entities, SelectedField $selectedField, Player $currentPlayer)
    {
        $this->entities = $entities;
        $this->selectedField = $selectedField;
        $this->currentPlayer = $currentPlayer;
    }

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getSelectedField(): SelectedField
    {
        return $this->selectedField;
    }

    public function getCurrentPlayer(): Player
    {
        return $this->currentPlayer;
    }
}
