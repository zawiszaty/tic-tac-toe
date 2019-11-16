<?php

declare(strict_types=1);

namespace App\Domain;

interface BoardRepositoryInterface
{
    public function add(Board $board): void;

    public function get(): Board;
}
