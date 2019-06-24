<?php

declare(strict_types=1);

namespace Tests\Domain;

use App\Domain\Board;
use App\Domain\Exception\BusyBoardException;
use App\Domain\Exception\WinnerException;
use App\Domain\ValueObject\Move;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_it_draw_board()
    {
        $board = new Board();
        $this->assertTrue(is_array($board->draw()));
    }

    public function test_it_check_field()
    {
        $board = new Board();
        $board->selectField();
        $entity = $board->draw()['entities'][$board->draw()['selectedField'][0]][$board->draw()['selectedField'][1]];
        $this->assertNotNull($entity);
        $this->assertSame($entity, 'X');
        $this->assertSame($board->draw()['currentPlayer'], '0');
    }

    public function test_it_check_busy_field()
    {
        $board = new Board();
        $board->selectField();
        $this->expectException(BusyBoardException::class);
        $board->selectField();
    }

    public function test_it_move_right()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertSame($board->draw()['selectedField'][1], 1);
    }

    public function test_it_move_right_when_out_of_map()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertFalse($board->move(Move::RIGHT));
    }

    public function test_it_move_left()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertTrue($board->move(Move::LEFT));
        $this->assertSame($board->draw()['selectedField'][1], 0);
    }

    public function test_it_move_left_when_out_of_map()
    {
        $board = new Board();
        $this->assertFalse($board->move(Move::LEFT));
    }

    public function test_it_move_up()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertTrue($board->move(Move::UP));
        $this->assertSame($board->draw()['selectedField'][0], 0);
    }

    public function test_it_move_up_when_out_of_map()
    {
        $board = new Board();
        $this->assertFalse($board->move(Move::UP));
    }

    public function test_it_move_down()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertSame($board->draw()['selectedField'][0], 1);
    }

    public function test_it_move_down_when_out_of_map()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertFalse($board->move(Move::DOWN));
    }

    public function test_it_winner()
    {
        $board = new Board();
        $board->selectField();
        $board->move(Move::DOWN);
        $board->selectField();
        $board->move(Move::UP);
        $board->move(Move::RIGHT);
        $board->selectField();
        $board->move(Move::DOWN);
        $board->selectField();
        $board->move(Move::UP);
        $board->move(Move::RIGHT);
        $this->expectException(WinnerException::class);
        $board->selectField();
    }
}
