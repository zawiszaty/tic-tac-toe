<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class WinnerException extends Exception
{
    public function __construct($winner)
    {
        $message = "The winner is: $winner";
        parent::__construct($message, 0, null);
    }
}
