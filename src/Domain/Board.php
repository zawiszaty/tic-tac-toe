<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Entity\Field;
use App\Domain\Exception\MoveException;
use App\Domain\Exception\WinnerException;
use App\Domain\ValueObject\BoardSize;
use App\Domain\ValueObject\Player;
use App\Domain\ValueObject\SelectedField;

class Board
{
    private $fields;

    private $selectedField;

    private $currentPlayer;

    private $boardSize;

    public function __construct(BoardSize $boardSize)
    {
        $this->boardSize     = $boardSize;
        $this->selectedField = new SelectedField(0, 0);
        $this->fields        = $this->createEntities();
        $this->currentPlayer = Player::PLAYER_X();
    }

    public function selectField(): void
    {
        /** @var Field $entity */
        $entity = $this->fields[$this->selectedField->getY()][$this->selectedField->getX()];
        $entity->choseField($this->currentPlayer);
        $this->checkIfWin();
        $this->changePlayer();
    }

    private function checkIfWin(): void
    {
        $result = [];

        foreach ($this->fields as $i => $row)
        {
            foreach ($row as $j => $cell)
            {
                if (null === $cell->getPlayer())
                {
                    $result[$i][$j] = 0;
                }
                else
                {
                    $result[$i][$j] = $cell->getPlayer()->equals($this->currentPlayer) ? 1 : 0;
                }
            }
        }

        $this->sumRowPlayer($result);

        $result = array_map(null, ...$result);

        $this->sumRowPlayer($result);

        if (3 === $result[0][0] + $result[1][1] + $result[2][2])
        {
            throw new WinnerException($this->currentPlayer);
        }

        if (3 === $result[0][2] + $result[1][1] + $result[2][0])
        {
            throw new WinnerException($this->currentPlayer);
        }
    }

    private function sumRowPlayer(array $result)
    {
        foreach ($result as $item)
        {
            if (3 === array_sum($item))
            {
                throw new WinnerException($this->currentPlayer);
            }
        }
    }

    private function changePlayer()
    {
        if (Player::PLAYER_X()->equals($this->currentPlayer)) {
            $this->currentPlayer = Player::PLAYER_O();
        } else {
            $this->currentPlayer = Player::PLAYER_X();
        }
    }

    public function move(SelectedField $selectedField): void
    {
        if (
            $selectedField->getX() > ($this->boardSize->getX() - 1)
            || $selectedField->getX() < 0
            || $selectedField->getY() > ($this->boardSize->getY() - 1)
            || $selectedField->getY() < 0
        )
        {
            throw MoveException::fromCannotMove();
        }
        $this->selectedField = $selectedField;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getSelectedField(): SelectedField
    {
        return $this->selectedField;
    }

    public function getCurrentPlayer(): Player
    {
        return $this->currentPlayer;
    }

    private function createEntities(): array
    {
        $entities = [];

        for ($i = 0; $i < $this->boardSize->getY(); $i++)
        {
            for ($j = 0; $j < $this->boardSize->getX(); $j++)
            {
                $entities[$i][] = new Field();
            }
        }

        return $entities;
    }
}
