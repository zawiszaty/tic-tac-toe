<?php

namespace App\Domain;

use App\Domain\Entity\BoardEntity;
use App\Domain\ValueObject\Move;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    function test_it_draw_board()
    {
        $board = new Board();
        $this->assertTrue(is_array($board->draw()));
    }

    function test_it_check_field()
    {
        $board = new Board();
        $board->selectField();
        $entity = $board->draw()['entities'][$board->draw()['selectedField'][0]][$board->draw()['selectedField'][1]];
        $this->assertNotNull($entity);
        $this->assertSame($entity, 'X');
        $this->assertSame($board->draw()['currentPlayer'], '0');
    }

    function test_it_move_right()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertSame($board->draw()['selectedField'][1], 1);
    }

    function test_it_move_right_when_out_of_map()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertFalse($board->move(Move::RIGHT));
    }

    function test_it_move_left()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertTrue($board->move(Move::LEFT));
        $this->assertSame($board->draw()['selectedField'][1], 0);
    }

    function test_it_move_left_when_out_of_map()
    {
        $board = new Board();
        $this->assertFalse($board->move(Move::LEFT));
    }

    function test_it_move_up()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertTrue($board->move(Move::UP));
        $this->assertSame($board->draw()['selectedField'][0], 0);
    }

    function test_it_move_up_when_out_of_map()
    {
        $board = new Board();
        $this->assertFalse($board->move(Move::UP));
    }

    function test_it_move_down()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertSame($board->draw()['selectedField'][0], 1);
    }

    function test_it_move_down_when_out_of_map()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertTrue($board->move(Move::DOWN));
        $this->assertFalse($board->move(Move::DOWN));
    }

    function test_it_winner()
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
