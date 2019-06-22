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
        /** @var BoardEntity $entity */
        $entity = $board->getEntities()[$board->getSelectedField()[0]][$board->getSelectedField()[1]];
        $this->assertTrue($entity->isBusy());
        $this->assertSame($entity->getPlayer(), 'X');
    }

    function test_it_move_right()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertSame($board->getSelectedField()[1], 1);
    }

    function test_it_move_right_when_out_of_map()
    {
        $board = new Board();
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertTrue($board->move(Move::RIGHT));
        $this->assertFalse($board->move(Move::RIGHT));
    }
}
