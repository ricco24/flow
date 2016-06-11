<?php

namespace Kelemen\Flow\Renderer;

use Kelemen\Flow\Action\Action;
use Symfony\Component\Console\Output\OutputInterface;

interface Renderer
{
	/**
	 * Set output to renderer
	 * @param OutputInterface $output
	 * @return mixed
	 */
	public function setOutput(OutputInterface $output);

	/**
	 * Writes a message to the output.
	 * @param Action $action
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function write(Action $action, $msg, $innerLevel = 0);

	/**
	 * Writes a message to the output and adds a newline at the end.
	 * @param Action $action
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeln(Action $action, $msg, $innerLevel = 0);

	/**
	 * Write a skip message to the output and adds a newline at the end.
	 * @param Action $action
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeSkip(Action $action, $msg, $innerLevel = 0);

	/**
	 * Write a success message to the output and adds a newline at the end.
	 * @param Action $action
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeSuccess(Action $action, $msg, $innerLevel = 0);

	/**
	 * Write a error message to the output and adds a newline at the end.
	 * @param Action $action
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeError(Action $action, $msg, $innerLevel = 0);

	/**
	 * Write a separator to the output
	 * @return void
	 */
	public function writeCommandSeparator();

	/**
	 * Returns highlighted string ready for write to output
	 * @param string $msg
	 * @return string
	 */
	public function highlight($msg);
}