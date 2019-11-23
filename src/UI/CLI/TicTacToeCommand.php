<?php

declare(strict_types=1);

namespace App\UI\CLI;

use App\Application\BoardService;
use App\Domain\Exception\BusyFieldException;
use App\Domain\Exception\WinnerException;
use App\Infrastructure\Presenter\BoardView;
use App\UI\Action\Move\MoveDownAction;
use App\UI\Action\Move\MoveException;
use App\UI\Action\Move\MoveLeftAction;
use App\UI\Action\Move\MoveRightAction;
use App\UI\Action\Move\MoveUpAction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class TicTacToeCommand extends Command
{
    protected static $defaultName = 'play';

    private $boardService;

    private $mappings = [
        65 => 'up',
        66 => 'down',
        68 => 'left',
        67 => 'right',
        56 => 'up',
        50 => 'down',
        52 => 'left',
        54 => 'right',
        10 => 'enter',
    ];

    public function __construct(BoardService $boardService)
    {
        parent::__construct();
        $this->boardService = $boardService;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->boardService->create(3, 3);
        $io       = new SymfonyStyle($input, $output);
        $mappings = [];

        foreach ($this->mappings as $key => $dir)
        {
            $mappings[$key] = [$dir, 0];
        }


        system('stty cbreak -echo');
        $stdin = fopen('php://stdin', 'r');
        while (1)
        {
            echo "\033c";
            $board = $this->boardService->get();
            $io->success(sprintf('Current Player is: %s', $board->getCurrentPlayer()->getValue()));
            $entities = $this->getEntitiesView($this->boardService->draw());
            $this->render($output, $entities);
            $c = ord(fgetc($stdin));

            if (isset($mappings[$c]))
            {
                $mapping = $mappings[$c];
                try
                {
                    switch ($mapping[0])
                    {
                        case 'up':
                            $this->boardService->move(new MoveUpAction());
                            break;
                        case 'down':
                            $this->boardService->move(new MoveDownAction());
                            break;
                        case 'left':
                            $this->boardService->move(new MoveLeftAction());
                            break;
                        case 'right':
                            $this->boardService->move(new MoveRightAction());
                            break;
                        case 'enter':
                            $this->boardService->selectField();
                            break;
                    }
                }
                catch (MoveException $exception)
                {
                }
                catch (BusyFieldException $exception)
                {
                }
                catch (WinnerException $exception)
                {
                    break;
                }
            }
        }
        echo "\033c";
        $io->success(sprintf('Player: %s win', $board->getCurrentPlayer()->getValue()));
    }

    private function getEntitiesView(BoardView $boardView): array
    {
        $entities = [];

        /** @var array $entity */
        foreach ($boardView->getEntities() as $y => $entity)
        {
            $renderEntity = [];
            foreach ($entity as $x => &$item)
            {
                if ($boardView->getSelectedField()->getX() === $x && $boardView->getSelectedField()->getY() === $y)
                {
                    $renderEntity[] = 'P';
                }
                else
                {
                    $renderEntity[] = $item;
                }
            }
            unset($item);
            $entities[] = $renderEntity;

            if (2 !== $y)
            {
                $entities[] = new TableSeparator();
            }
        }

        return $entities;
    }

    private function render(OutputInterface $output, array $entities): void
    {
        $table = new Table($output);
        $table
            ->setRows(
                $entities
            );
        $table->render();
    }
}
