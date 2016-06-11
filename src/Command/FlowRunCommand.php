<?php

namespace Kelemen\Flow\Command;

use Kelemen\Flow\Flow;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FlowRunCommand extends Command
{
	/** @var Flow */
	private $flow;

	/**
	 * @param Flow $flow
	 * @param string|null $name
	 * @param string|null $description
	 */
	public function __construct(Flow $flow, $name = null, $description = null)
	{
		parent::__construct($name);
		$this->flow = $flow;

		$this->setName($name ?: 'flow:run');
		$this->setDescription($description ?: 'Execute all registered actions.');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->registerStyles($output);
		$this->flow->run($output);
	}

	/**
	 * Register new styles
	 * @param OutputInterface $output
	 */
	private function registerStyles($output)
	{
		$output->getFormatter()->setStyle('error', new OutputFormatterStyle('red', 'black'));
		$output->getFormatter()->setStyle('yellow', new OutputFormatterStyle('yellow', 'black'));
		$output->getFormatter()->setStyle('magenta', new OutputFormatterStyle('magenta', 'black'));
	}
}