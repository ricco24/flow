<?php

namespace Kelemen\Flow\Renderer;

use Symfony\Component\Console\Output\OutputInterface;

interface Renderer
{
	/**
	 * Writes a message to the output.
	 * @param OutputInterface $output
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function write(OutputInterface $output, $msg, $innerLevel = 0);

	/**
	 * Writes a message to the output and adds a newline at the end.
	 * @param OutputInterface $output
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeln(OutputInterface $output, $msg, $innerLevel = 0);

	/**
	 * Write a skip message to the output and adds a newline at the end.
	 * @param OutputInterface $output
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeSkip(OutputInterface $output, $msg, $innerLevel = 0);

	/**
	 * Write a success message to the output and adds a newline at the end.
	 * @param OutputInterface $output
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeSuccess(OutputInterface $output, $msg, $innerLevel = 0);

	/**
	 * Write a error message to the output and adds a newline at the end.
	 * @param OutputInterface $output
	 * @param string $msg
	 * @param int $innerLevel
	 * @return void
	 */
	public function writeError(OutputInterface $output, $msg, $innerLevel = 0);

	/**
	 * Write a separator to the output
	 * @param OutputInterface $output
	 * @return void
	 */
	public function writeSeparator(OutputInterface $output);

	/**
	 * Returns highlighted string ready for write to output
	 * @param string $msg
	 * @return string
	 */
	public function highlight($msg);
}