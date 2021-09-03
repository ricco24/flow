<?php

namespace Kelemen\Flow\Action\Composer;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Action\Command\RunCommand;
use Kelemen\Flow\Renderer\Renderer;

class InstallComposer extends Action
{
	/** @var string */
	private $dir;

	/**
	 * @param string $dir
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
		$this->runAction(new RunCommand('cd ' . $this->dir . ' && composer install', true, null, null, null, 1800), $renderer);
	}
}
