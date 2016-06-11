<?php

namespace Kelemen\Flow\Action\Directory;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteDirectory extends Action
{
	/** @var string */
	private $dir;

	/**
	 * @param $dir
	 */
	public function __construct($dir)
	{
		$this->dir = realpath($dir);
	}

	/**
	 * @param OutputInterface $output
	 * @param Renderer $renderer
	 */
	public function run(OutputInterface $output, Renderer $renderer)
	{
		$renderer->writeln($output, 'Deleting directory ' . $renderer->highlight($this->dir));

		if (!is_dir($this->dir)) {
			$renderer->writeSkip($output, 'Directory ' . $renderer->highlight($this->dir) . ' not found');
			return;
		}

		rmdir($this->dir)
			? $renderer->writeSuccess($output, 'Directory ' . $renderer->highlight($this->dir) . ' was deleted')
			: $renderer->writeError($output, 'Directory ' . $renderer->highlight($this->dir) . ' was not deleted');
	}
}