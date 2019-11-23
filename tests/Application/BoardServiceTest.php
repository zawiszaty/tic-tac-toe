<?php

declare(strict_types=1);

namespace Tests\Application;

use App\Application\BoardService;
use App\Domain\Entity\Field;
use App\Infrastructure\BoardRepositoryRepository;
use App\Infrastructure\Presenter\BoardPresenter;
use App\UI\Action\Move\MoveRightAction;
use PHPUnit\Framework\TestCase;

class BoardServiceTest extends TestCase
{
    /**
     * @var BoardRepositoryRepository
     */
    private $repo;

    /**
     * @var BoardService
     */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repo = new BoardRepositoryRepository();
        $this->service = new BoardService($this->repo, new BoardPresenter());
    }

    public function test_it_create_board(): void
    {
        $this->service->create(3, 3);
        $this->repo->get();
        $this->assertSame(1, 1);
    }

    public function test_it_can_move(): void
    {
        $this->service->create(3, 3);
        $this->service->move(new MoveRightAction());
        $board = $this->repo->get();
        $selectedField = $board->getSelectedField();
        $this->assertSame(1, $selectedField->getX());
    }

    public function test_it_select_field(): void
    {
        $this->service->create(3, 3);
        $this->service->selectField();
        $board = $this->repo->get();
        $this->assertSame('0', $board->getCurrentPlayer()->getValue());
        /** @var Field $field */
        $field = $board->getFields()[0][0];
        $this->assertTrue($field->isBusy());
    }
}
