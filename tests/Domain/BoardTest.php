<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Board;
use App\Domain\Exception\BusyBoardException;
use App\Domain\Exception\MoveException;
use App\Domain\Exception\WinnerException;
use App\Domain\Policy\Move\MoveDownPolicy;
use App\Domain\Policy\Move\MoveLeftPolicy;
use App\Domain\Policy\Move\MoveRightPolicy;
use App\Domain\Policy\Move\MoveUpPolicy;
use App\Domain\ValueObject\Player;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_it_check_field(): void
    {
        $board = new Board();
        $board->selectField();
        $boardView = $board->draw();
        $selectedField = $boardView->getSelectedField();
        /** @var Player $player */
        $player = $boardView->getEntities()[$selectedField->getX()][$selectedField->getY()];
        $this->assertNotNull($player);
        $this->assertTrue($player->equals(new Player('X')));
        $this->assertTrue($boardView->getCurrentPlayer()->equals(new Player('0')));
    }

    public function test_it_check_busy_field(): void
    {
        $board = new Board();
        $board->selectField();
        $this->expectException(BusyBoardException::class);
        $board->selectField();
    }

    public function test_it_move_right(): void
    {
        $board = new Board();
        $policy = new MoveRightPolicy();
        $board->move($policy);
        $this->assertSame($board->draw()->getSelectedField()->getX(), 1);
    }

    public function test_it_move_right_when_out_of_map(): void
    {
        $board = new Board();
        $policy = new MoveRightPolicy();
        $board->move($policy);
        $board->move($policy);
        $this->expectException(MoveException::class);
        $board->move($policy);
    }

    public function test_it_move_left(): void
    {
        $board = new Board();
        $board->move(new MoveRightPolicy());
        $board->move(new MoveLeftPolicy());
        $this->assertSame($board->draw()->getSelectedField()->getX(), 0);
    }

    public function test_it_move_left_when_out_of_map(): void
    {
        $board = new Board();
        $policy = new MoveLeftPolicy();
        $this->expectException(MoveException::class);
        $board->move($policy);
    }

    public function test_it_move_up(): void
    {
        $board = new Board();
        $board->move(new MoveDownPolicy());
        $board->move(new MoveUpPolicy());
        $this->assertSame($board->draw()->getSelectedField()->getY(), 0);
    }

    public function test_it_move_up_when_out_of_map(): void
    {
        $board = new Board();
        $policy = new MoveUpPolicy();
        $this->expectException(MoveException::class);
        $board->move($policy);
    }

    public function test_it_move_down(): void
    {
        $board = new Board();
        $policy = new MoveDownPolicy();
        $board->move($policy);
        $this->assertSame($board->draw()->getSelectedField()->getY(), 1);
    }

    public function test_it_move_down_when_out_of_map(): void
    {
        $board = new Board();
        $policy = new MoveDownPolicy();
        $board->move($policy);
        $board->move($policy);
        $this->expectException(MoveException::class);
        $board->move($policy);
    }

    public function test_it_winner()
    {
        $board = new Board();
        $board->selectField();
        $board->move(new MoveDownPolicy());
        $board->selectField();
        $board->move(new MoveUpPolicy());
        $board->move(new MoveRightPolicy());
        $board->selectField();
        $board->move(new MoveDownPolicy());
        $board->selectField();
        $board->move(new MoveUpPolicy());
        $board->move(new MoveRightPolicy());
        $this->expectException(WinnerException::class);
        $board->selectField();
    }
}
