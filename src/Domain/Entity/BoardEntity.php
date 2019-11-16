<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\BusyBoardException;
use App\Domain\ValueObject\Player;

class BoardEntity
{
    /**
     * @var bool
     */
    private $busy;

    /**
     * @var Player|null
     */
    private $player;

    public function __construct()
    {
        $this->busy = false;
        $this->player = null;
    }

    public function isBusy(): bool
    {
        return $this->busy;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function choseField(Player $player): void
    {
        if ($this->isBusy()) {
            throw new BusyBoardException();
        }
        $this->busy = true;
        $this->player = $player;
    }
}
