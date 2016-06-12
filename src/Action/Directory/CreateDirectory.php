<?php

namespace Kelemen\Flow\Action\Directory;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;

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
		$this->dir = $dir;
		$this->mode = $mode;
		$this->recursive = $recursive;
		$this->force = $force;
	}

	/**

	 * @param Renderer $renderer
	 */
	public function run(Renderer $renderer)
	{
		$renderer->writeln($this, 'Creating directory ' . $renderer->highlight($this->dir));

		if (is_dir($this->dir)) {
			if (!$this->force) {
				$renderer->writeSkip($this, 'Directory ' . $renderer->highlight($this->dir) . ' exists');
				return;
			}

			$this->runAction(new DeleteDirectory($this->dir), $renderer);
		}

		@mkdir($this->dir, $this->mode, $this->recursive)
			? $renderer->writeSuccess($this, 'Directory ' . $renderer->highlight($this->dir) . ' was created')
			: $renderer->writeError($this, 'Directory ' . $renderer->highlight($this->dir) . ' was not created');
	}
}