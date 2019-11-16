<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Entity\BoardEntity;
use App\Domain\Exception\WinnerException;
use App\Domain\Policy\Move\MovePolicyInterface;
use App\Domain\ValueObject\BoardView;
use App\Domain\ValueObject\Player;
use App\Domain\ValueObject\SelectedField;

class Board
{
    private $entities;

    private $selectedField;

    private $currentPlayer;

    public function __construct()
    {
        $this->selectedField = new SelectedField(0, 0);
        $this->entities = [
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
            [new BoardEntity(), new BoardEntity(), new BoardEntity()],
        ];
        $this->currentPlayer = Player::PLAYER_X();
    }

    public function draw(): BoardView
    {
        return new BoardView(
            $this->prepareForDrawing(),
            $this->selectedField,
            $this->currentPlayer,
        );
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

    public function selectField(): void
    {
        /** @var BoardEntity $entity */
        $entity = $this->entities[$this->selectedField->getX()][$this->selectedField->getY()];
        $entity->choseField($this->currentPlayer);
        $this->checkIfWin();
        $this->changePlayer();
    }

    private function checkIfWin(): void
    {
        if (false === empty($this->entities[0][0]->getPlayer()) && false === empty($this->entities[0][1]->getPlayer()) && false === empty($this->entities[0][2]->getPlayer())) {
            if ($this->entities[0][0]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[0][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[0][2]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[1][0]->getPlayer()) && false === empty($this->entities[1][1]->getPlayer()) && false === empty($this->entities[1][2]->getPlayer())) {
            if ($this->entities[1][0]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][2]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[2][0]->getPlayer()) && false === empty($this->entities[2][1]->getPlayer()) && false === empty($this->entities[2][2]->getPlayer())) {
            if ($this->entities[2][0]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][2]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[0][0]->getPlayer()) && false === empty($this->entities[1][0]->getPlayer()) && false === empty($this->entities[2][0]->getPlayer())) {
            if ($this->entities[0][0]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][0]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][0]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[0][1]->getPlayer()) && false === empty($this->entities[1][1]->getPlayer()) && false === empty($this->entities[2][1]->getPlayer())) {
            if ($this->entities[0][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][1]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[0][2]->getPlayer()) && false === empty($this->entities[1][2]->getPlayer()) && false === empty($this->entities[2][2]->getPlayer())) {
            if ($this->entities[0][2]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][2]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][2]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[0][0]->getPlayer()) && false === empty($this->entities[1][1]->getPlayer()) && false === empty($this->entities[2][2]->getPlayer())) {
            if ($this->entities[0][0]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][2]->getPlayer()->equals($this->currentPlayer)) {
                throw new WinnerException($this->currentPlayer);
            }
        }

        if (false === empty($this->entities[0][2]->getPlayer()) && false === empty($this->entities[1][1]->getPlayer()) && false === empty($this->entities[2][0]->getPlayer())) {
            if ($this->entities[0][2]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[1][1]->getPlayer()->equals($this->currentPlayer) &&
                $this->entities[2][0]->getPlayer()->equals($this->currentPlayer)) {
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

    public function move(MovePolicyInterface $movePolicy): void
    {
        $this->selectedField = $movePolicy->move($this->selectedField);
    }
}
