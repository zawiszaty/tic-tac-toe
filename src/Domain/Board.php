<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Entity\BoardEntity;
use App\Domain\Exception\WinnerException;
use App\Domain\ValueObject\Move;
use App\Domain\ValueObject\Player;

class Board
{
    /**
     * @var array<array<BoardEntity>>
     */
    private $entities;

    private $selectedField;

    private $currentPlayer;

    public function __construct()
    {
        $this->selectedField = [0, 0];
        $this->entities = [
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
        ];
        $this->currentPlayer = Player::PLAYER_X;
    }

    public function draw(): array
    {
        return [
            'entities' => $this->prepareForDrawing(),
            'selectedField' => $this->selectedField,
            'currentPlayer' => $this->currentPlayer,
        ];
    }

    private function prepareForDrawing(): array
    {
        $entities = array_map(function (array $entity) {
            $data = array_map(function (BoardEntity $boardEntity) {
                return $boardEntity->getPlayer();
            }, $entity);

            return $data;
        }, $this->entities);

        return $entities;
    }

    /**
     * @throws WinnerException
     * @throws Exception\BusyBoardException
     */
    public function selectField(): void
    {
        /** @var BoardEntity $entity */
        $entity = $this->entities[$this->selectedField[0]][$this->selectedField[1]];
        $entity->choseField($this->currentPlayer);
        $this->checkIfWin();
        $this->changePlayer();
    }

    private function checkIfWin(): void
    {
        if (
            ($this->entities[0][0]->getPlayer() === $this->currentPlayer &&
                $this->entities[0][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[0][2]->getPlayer() === $this->currentPlayer) ||

            ($this->entities[1][0]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][2]->getPlayer() == $this->currentPlayer) ||

            ($this->entities[2][0]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][2]->getPlayer() == $this->currentPlayer) ||

            ($this->entities[0][0]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][0]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][0]->getPlayer() == $this->currentPlayer) ||

            ($this->entities[0][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][1]->getPlayer() == $this->currentPlayer) ||

            ($this->entities[0][2]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][2]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][2]->getPlayer() == $this->currentPlayer) ||

            ($this->entities[0][0]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][2]->getPlayer() == $this->currentPlayer) ||

            ($this->entities[0][2]->getPlayer() === $this->currentPlayer &&
                $this->entities[1][1]->getPlayer() === $this->currentPlayer &&
                $this->entities[2][0]->getPlayer() == $this->currentPlayer)
        ) {
            throw new WinnerException($this->currentPlayer);
        }
    }

    private function changePlayer()
    {
        if (Player::PLAYER_X === $this->currentPlayer) {
            $this->currentPlayer = Player::PLAYER_O;
        } else {
            $this->currentPlayer = Player::PLAYER_X;
        }
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
            case Move::LEFT:
                if ($this->selectedField[1] - 1 >= 0) {
                    $this->selectedField[1] = $this->selectedField[1] - 1;

                    return true;
                }
                break;
            case Move::UP:
                if ($this->selectedField[0] - 1 >= 0) {
                    $this->selectedField[0] = $this->selectedField[0] - 1;

                    return true;
                }
                break;
            case Move::DOWN:
                if ($this->selectedField[0] + 1 <= 2) {
                    $this->selectedField[0] = $this->selectedField[0] + 1;

                    return true;
                }
                break;
        }

        return false;
    }
}
