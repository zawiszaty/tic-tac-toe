<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Board;
use App\Domain\BoardRepositoryInterface;
use Exception;

final class BoardRepositoryRepository implements BoardRepositoryInterface
{
    /** @var Board|null */
    private $board;

    public function add(Board $board): void
    {
        $this->board = $board;
    }

    public function get(): Board
    {
        if ($this->board instanceof Board) {
            return $this->board;
        }

        throw new Exception('Board Not Found');
    }
}
