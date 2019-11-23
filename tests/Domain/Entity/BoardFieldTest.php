<?php

declare(strict_types=1);

namespace Tests\Domain\Entity;

use App\Domain\Entity\Field;
use App\Domain\ValueObject\Player;
use PHPUnit\Framework\TestCase;

class BoardFieldTest extends TestCase
{
    public function testIsBusy()
    {
        $entity = new Field();
        $entity->choseField(new Player('X'));
        $this->assertSame($entity->getPlayer()->getValue(), 'X');
        $this->assertTrue($entity->isBusy());
    }
}
