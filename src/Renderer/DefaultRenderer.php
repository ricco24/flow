<?php

namespace Kelemen\Flow\Action;

use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultRenderer implements Renderer
{
	public function write(OutputInterface $output, $msg, $innerLevel = 0)
	{
		$output->write(str_repeat(' ', ($this->level + $innerLevel) * 2) . '-> ' . $msg);
	}

	public function writeln(OutputInterface $output, $msg, $innerLevel = 0)
	{
		$output->writeln(str_repeat(' ', ($this->level + $innerLevel) * 2) . '-> ' . $msg);
	}

	public function writeSkip(OutputInterface $output, $msg, $innerLevel = 0)
	{
		$this->writeln($output, '<yellow>[SKIPPING]</yellow> ' . $msg, $innerLevel);
	}

	public function writeSuccess(OutputInterface $output, $msg, $innerLevel = 0)
	{
		$this->writeln($output, '<info>[SUCCESS]</info> ' . $msg, $innerLevel);
	}

	public function writeError(OutputInterface $output, $msg, $innerLevel = 0)
	{
		$this->writeln($output, '<error>[ERROR]</error> ' . $msg, $innerLevel);
	}

	public function highlight($msg)
	{
		return '<magenta>' . $msg . '</magenta>';
	}

	public function writeSeparator(OutputInterface $output)
	{
		$output->writeln("\n **** Command ****\n");
	}
}