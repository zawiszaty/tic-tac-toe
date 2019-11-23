<?php

declare(strict_types=1);

namespace App\Application;

use App\Domain\Board;
use App\Domain\BoardRepositoryInterface;
use App\Domain\ValueObject\BoardSize;
use App\Infrastructure\Presenter\BoardPresenter;
use App\Infrastructure\Presenter\BoardView;
use App\UI\Action\Move\MoveActionInterface;

final class BoardService
{
    private $boardRepository;

    private $boardPresenter;

    public function __construct(BoardRepositoryInterface $boardRepository, BoardPresenter $boardPresenter)
    {
        $this->boardRepository = $boardRepository;
        $this->boardPresenter = $boardPresenter;
    }

    public function create(int $x, int $y): void
    {
        $board = new Board(new BoardSize($x, $y));
        $this->boardRepository->add($board);
    }

    public function get(): Board
    {
        return $this->boardRepository->get();
    }

    public function move(MoveActionInterface $action): void
    {
        $board = $this->boardRepository->get();
        $selectedField = $action->move($board->getSelectedField());
        $board->move($selectedField);
        $this->boardRepository->add($board);
    }

    public function draw(): BoardView
    {
        $board = $this->boardRepository->get();

        return $this->boardPresenter->draw($board);
    }

    public function selectField(): void
    {
        $board = $this->boardRepository->get();

        $board->selectField();
    }
}
