<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\BusyFieldException;
use App\Domain\ValueObject\Player;

class Field
{
    private $player;

    public function isBusy(): bool
    {
        return !empty($this->player);
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function choseField(Player $player): void
    {
        if ($this->isBusy()) {
            throw new BusyFieldException();
        }
        $this->player = $player;
    }
}
