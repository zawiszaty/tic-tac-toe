<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class BusyFieldException extends \Exception
{
    protected $message = 'Field is Busy';
}
