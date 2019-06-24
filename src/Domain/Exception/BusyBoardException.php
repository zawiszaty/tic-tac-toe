<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class BusyBoardException extends \Exception
{
    protected $message = 'Board is Busy';
}
