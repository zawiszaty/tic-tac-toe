<?php


namespace App\Domain;


use App\Domain\Entity\BoardEntity;
use App\Domain\ValueObject\Move;

class Board
{
    /**
     * @var array<BoardEntity>
     */
    private $entities;

    private $selectedField;

    public function __construct()
    {
        $this->selectedField = [0, 0];
        $this->entities = [
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
            [new BoardEntity(), new BoardEntity(), new BoardEntity()]
        ];
    }

    public function draw(): array
    {
        return $this->entities;
    }

    public function selectField(): void
    {
        /** @var BoardEntity $entity */
        $entity = $this->entities[$this->selectedField[0]][$this->selectedField[1]];
        $entity->choseField('X');
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @return array
     */
    public function getSelectedField(): array
    {
        return $this->selectedField;
    }

    public function move(string $side): bool
    {
        switch ($side) {
            case Move::RIGHT:
                if ($this->selectedField[1] + 1 <= 2) {
                    $this->selectedField[1] = $this->selectedField[1] + 1;
                    return true;
                }
                break;
        }
        return false;
    }
}