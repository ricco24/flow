<?php

namespace Kelemen\Flow\Action\Directory;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDirectory extends Action
{
	/** @var string */
	private $dir;

	/** @var int */
	private $mode;

	/** @var bool */
	private $recursive;

	/** @var bool */
	private $force;

	/**
	 * @param string $dir
	 * @param int $mode
	 * @param bool $recursive
	 * @param bool $force
	 */
	public function __construct($dir, $mode = 0777, $recursive = false, $force = false)
	{
		$this->dir = realpath($dir);
		$this->mode = $mode;
		$this->recursive = $recursive;
		$this->force = $force;
	}

	/**
	 * @param OutputInterface $output
	 * @param Renderer $renderer
	 */
	public function run(OutputInterface $output, Renderer $renderer)
	{
		$renderer->writeln($output, 'Creating directory ' . $renderer->highlight($this->dir));

		if (is_dir($this->dir)) {
			if (!$this->force) {
				$renderer->writeSkip($output, 'Directory ' . $renderer->highlight($this->dir) . ' exists');
				return;
			}

			$delete = new DeleteDirectory($this->dir);
			$delete->setLevel($this->getNextLevel());
			$delete->run($output);
		}

		mkdir($this->dir, $this->mode, $this->recursive)
			? $renderer->writeSuccess($output, 'Directory ' . $renderer->highlight($this->dir) . ' was created')
			: $renderer->writeError($output, 'Directory ' . $renderer->highlight($this->dir) . ' was not created');
	}
}