<?php


namespace App\Domain;


use Exception;

class WinnerException extends Exception
{
    public function __construct($winner)
    {
        $message = "The winner is: $winner";
        parent::__construct($message, 0, null);
    }
}