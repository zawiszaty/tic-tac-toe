<?php

declare(strict_types=1);

namespace Tests\Domain\Entity;

use App\Domain\Entity\BoardEntity;
use PHPUnit\Framework\TestCase;

class BoardEntityTest extends TestCase
{
    public function testIsBusy()
    {
        $entity = new BoardEntity();
        $entity->choseField('X');
        $this->assertSame($entity->getPlayer(), 'X');
        $this->assertTrue($entity->isBusy());
    }
}
