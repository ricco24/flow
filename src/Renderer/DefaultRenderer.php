<?php

namespace Kelemen\Flow\Action;

use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultRenderer implements Renderer
{
	/** @var OutputInterface */
	private $output;

	public function setOutput(OutputInterface $output)
	{
		$this->output = $output;
		$this->registerStyles($this->output);
	}

	public function write(Action $action, $msg, $innerLevel = 0)
	{
		$this->output->write(str_repeat(' ', ($action->getLevel() + $innerLevel) * 2) . '-> ' . $msg);
	}

	public function writeln(Action $action, $msg, $innerLevel = 0)
	{
		$this->output->writeln(str_repeat(' ', ($action->getLevel() + $innerLevel) * 2) . '-> ' . $msg);
	}

	public function writeSkip(Action $action, $msg, $innerLevel = 0)
	{
		$this->writeln($action, '<yellow>[SKIPPING]</yellow> ' . $msg, $innerLevel);
	}

	public function writeSuccess(Action $action, $msg, $innerLevel = 0)
	{
		$this->writeln($action, '<info>[SUCCESS]</info> ' . $msg, $innerLevel);
	}

	public function writeError(Action $action, $msg, $innerLevel = 0)
	{
		$this->writeln($action, '<error>[ERROR]</error> ' . $msg, $innerLevel);
	}

	public function highlight($msg)
	{
		return '<magenta>' . $msg . '</magenta>';
	}

	public function writeCommandSeparator()
	{
		$this->output->writeln("\n **** Command ****\n");
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