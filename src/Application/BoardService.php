<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Board;
use App\Domain\BoardRepositoryInterface;

final class BoardService
{
    private $boardRepository;

    public function __construct(BoardRepositoryInterface $boardRepository)
    {
        $this->boardRepository = $boardRepository;
    }

    public function create(): void
    {
        $board = new Board();
        $this->boardRepository->add($board);
    }
}
