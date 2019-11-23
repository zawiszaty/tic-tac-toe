<?php

declare(strict_types=1);

namespace App\Infrastructure\Presenter;

use App\Domain\Board;
use App\Domain\Entity\Field;

final class BoardPresenter
{
    public function draw(Board $board): BoardView
    {
        return new BoardView(
            $this->prepareForDrawing($board->getFields()),
            $board->getSelectedField(),
            $board->getCurrentPlayer(),
        );
    }

    private function prepareForDrawing(array $boardEntities): array
    {
        $entities = array_map(static function (array $entity) {
            $data = array_map(static function (Field $boardEntity) {
                return $boardEntity->getPlayer();
            }, $entity);

            return $data;
        }, $boardEntities);

        return $entities;
    }
}
