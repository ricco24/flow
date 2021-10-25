<?php

namespace Kelemen\Flow\Command;

use Kelemen\Flow\Flow;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FlowRunCommand extends Command
{
    /** @var Flow */
    private $flow;

    public function __construct(Flow $flow, string $name = null, string $description = null)
    {
        parent::__construct($name);
        $this->flow = $flow;

        $this->setName($name ?: 'flow:run');
        $this->setDescription($description ?: 'Execute all registered actions.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->flow->run($output);
    }
}
