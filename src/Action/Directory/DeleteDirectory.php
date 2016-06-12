<?php

namespace Kelemen\Flow\Action\Directory;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;

class DeleteDirectory extends Action
{
	/** @var string */
	private $dir;

	/**
	 * @param $dir
	 */
	public function __construct($dir)
	{
		$this->dir = $dir;
	}

	/**
	 * @param Renderer $renderer
	 */
	public function run(Renderer $renderer)
	{
		$renderer->writeln($this, 'Deleting directory ' . $renderer->highlight($this->dir));

		if (!is_dir($this->dir)) {
			$renderer->writeSkip($this, 'Directory ' . $renderer->highlight($this->dir) . ' not found');
			return;
		}

		$this->remove($this->dir)
			? $renderer->writeSuccess($this, 'Directory ' . $renderer->highlight($this->dir) . ' was deleted')
			: $renderer->writeError($this, 'Directory ' . $renderer->highlight($this->dir) . ' was not deleted');
	}

	/**
	 * Remove dir recursive
	 * @param string $dir
	 * @return bool
	 */
	private function remove($dir)
	{
		$files = array_diff(scandir($dir), ['.','..']);
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? $this->remove("$dir/$file") : @unlink("$dir/$file");
		}
		return @rmdir($dir);
	}
}