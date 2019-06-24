<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\BusyBoardException;

class BoardEntity
{
    /**
     * @var bool
     */
    private $busy;

    /**
     * @var string|null
     */
    private $player;

    public function __construct()
    {
        $this->busy = false;
        $this->player = null;
    }

    /**
     * @return bool
     */
    public function isBusy(): bool
    {
        return $this->busy;
    }

    /**
     * @return string
     */
    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function choseField(string $player): void
    {
        if ($this->isBusy()) {
            throw new BusyBoardException();
        }
        $this->busy = true;
        $this->player = $player;
    }
}
