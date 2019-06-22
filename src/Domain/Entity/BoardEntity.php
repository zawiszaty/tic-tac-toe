<?php


namespace App\Domain\Entity;


class BoardEntity
{
    /**
     * @var boolean
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
        $this->busy = true;
        $this->player = $player;
    }
}