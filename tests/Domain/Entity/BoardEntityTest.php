<?php

declare(strict_types=1);

namespace Tests\Domain\Entity;

use App\Domain\Entity\BoardEntity;
use App\Domain\ValueObject\Player;
use PHPUnit\Framework\TestCase;

class BoardEntityTest extends TestCase
{
    public function testIsBusy()
    {
        $entity = new BoardEntity();
        $entity->choseField(new Player('X'));
        $this->assertSame($entity->getPlayer()->getValue(), 'X');
        $this->assertTrue($entity->isBusy());
    }
}
