<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class Application extends ConsoleApplication
{
    /** @var ContainerBuilder */
    private $container;
    /** @var string */
    private $env;

    public function __construct(string $env)
    {
        parent::__construct('test', '0');
        $this->env = $env;
        $this->container = new ContainerBuilder();
        $this->setUpContainer();
    }

    private function setUpContainer(): void
    {
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../config'));
        $loader->load('services.yaml');
        foreach ($this->container->findTaggedServiceIds('console') as $commandId => $command) {
            /** @var Command $command */
            $command = $this->container->get($commandId);
            $this->add($command);
        }
    }
}
