<?php

namespace Kelemen\Flow\Action;

use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Action
{
	/** @var int */
	private $level = 1;

	/**
	 * @param int $level
	 */
	public function setLevel($level)
	{
		$this->level = (int) $level;
	}

	/**
	 * @return int
	 */
	public function getLevel()
	{
		return $this->level;
	}

	/**
	 * @return int
	 */
	public function getNextLevel()
	{
		return $this->level + 1;
	}

	/**
	 * Execute action
	 * @param Renderer $renderer
	 * @return void
	 */
	abstract public function run(Renderer $renderer);
}