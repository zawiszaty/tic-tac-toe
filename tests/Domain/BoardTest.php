<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Board;
use App\Domain\Entity\Field;
use App\Domain\Exception\BusyFieldException;
use App\Domain\Exception\MoveException;
use App\Domain\Exception\WinnerException;
use App\Domain\ValueObject\BoardSize;
use App\Domain\ValueObject\Player;
use App\Domain\ValueObject\SelectedField;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_it_check_field(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->selectField();
        $selectedField = $board->getSelectedField();
        $entities = $board->getFields();
        $currentPlayer = $board->getCurrentPlayer();
        /** @var Field $boardEntity */
        $boardEntity = $entities[$selectedField->getX()][$selectedField->getY()];
        $player = $boardEntity->getPlayer();
        $this->assertNotNull($player);
        $this->assertTrue($player->equals(new Player('X')));
        $this->assertTrue($currentPlayer->equals(new Player('0')));
    }

    public function test_it_check_busy_field(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->selectField();
        $this->expectException(BusyFieldException::class);
        $board->selectField();
    }

    public function test_it_move_right(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->move(new SelectedField(1, 0));
        $this->assertSame($board->getSelectedField()->getX(), 1);
    }

    public function test_it_move_right_when_out_of_map(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $this->expectException(MoveException::class);
        $board->move(new SelectedField(3, 0));
    }

    public function test_it_move_left(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->move(new SelectedField(2, 0));
        $board->move(new SelectedField(1, 0));
        $this->assertSame($board->getSelectedField()->getX(), 1);
    }

    public function test_it_move_left_when_out_of_map(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $this->expectException(MoveException::class);
        $board->move(new SelectedField(-1, 0));
    }

    public function test_it_move_up(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->move(new SelectedField(0, 2));
        $board->move(new SelectedField(0, 1));
        $this->assertSame($board->getSelectedField()->getY(), 1);
    }

    public function test_it_move_up_when_out_of_map(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $this->expectException(MoveException::class);
        $board->move(new SelectedField(0, -1));
    }

    public function test_it_move_down(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->move(new SelectedField(0, 2));
        $this->assertSame($board->getSelectedField()->getY(), 2);
    }

    public function test_it_move_down_when_out_of_map(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $this->expectException(MoveException::class);
        $board->move(new SelectedField(0, 3));
    }

    public function test_it_winner(): void
    {
        $board = new Board(new BoardSize(3, 3));
        $board->selectField();
        $board->move(new SelectedField(0, 1));
        $board->selectField();
        $board->move(new SelectedField(1, 0));
        $board->selectField();
        $board->move(new SelectedField(1, 1));
        $board->selectField();
        $board->move(new SelectedField(2, 0));
        $this->expectException(WinnerException::class);
        $board->selectField();
    }
}
