<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use MyCLabs\Enum\Enum;

/**
 * @method static Player PLAYER_X()
 * @method static Player PLAYER_O()
 */
class Player extends Enum
{
    private const PLAYER_X = 'X';
    private const PLAYER_O = '0';
}
