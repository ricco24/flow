<?php

namespace Kelemen\Flow;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Action\Command\RunCommand;
use Kelemen\Flow\Action\Composer\InstallComposer;
use Kelemen\Flow\Action\Composer\UpdateComposer;
use Kelemen\Flow\Action\Database\Mysql\CreateDatabaseMysql;
use Kelemen\Flow\Action\Database\Mysql\DropDatabaseMysql;
use Kelemen\Flow\Action\DefaultRenderer;
use Kelemen\Flow\Action\Directory\CreateDirectory;
use Kelemen\Flow\Action\Directory\DeleteDirectory;
use Kelemen\Flow\Action\Directory\MoveDirectory;
use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Output\OutputInterface;

class Flow
{
	/** @var Renderer */
	private $renderer;

	/** @var array */
	private $actions = [];

	/**
	 * @param Renderer $renderer
	 */
	public function __construct(Renderer $renderer = null)
	{
		$this->renderer = $renderer ?: new DefaultRenderer();
	}

	/**
	 * @param Action $action
	 * @return Action
	 */
	public function addAction(Action $action)
	{
		$this->actions[] = $action;
		return $action;
	}

	/**
	 * @param OutputInterface $output
	 */
	public function run(OutputInterface $output)
	{
		$this->renderer->setOutput($output);

		foreach ($this->actions as $action) {
			$this->renderer->writeCommandSeparator();
			$action->run($this->renderer);
		}
	}

	/**********************************************************\
	 * Wrapper functions
	\**********************************************************/

	/**
	 * Create new directory
	 * @param string $dir
	 * @param int $mode
	 * @param bool $recursive
	 * @return Action
	 */
	public function createDirectory($dir, $mode = 0777, $recursive = false)
	{
		return $this->addAction(new CreateDirectory($dir, $mode, $recursive));
	}

	/**
	 * Create new directory, delete if already exists
	 * @param string $dir
	 * @param int $mode
	 * @param bool $recursive
	 * @return Action
	 */
	public function createDirectoryForce($dir, $mode = 0777, $recursive = false)
	{
		return $this->addAction(new CreateDirectory($dir, $mode, $recursive, true));
	}

	/**
	 * Delete directory
	 * @param string $dir
	 * @return Action
	 */
	public function deleteDirectory($dir)
	{
		return $this->addAction(new DeleteDirectory($dir));
	}

	/**
	 * Move directory to new destination
	 * @param string $oldDirName
	 * @param string $newDirName
	 * @return Action
	 */
	public function moveDirectory($oldDirName, $newDirName)
	{
		return $this->addAction(new MoveDirectory($oldDirName, $newDirName));
	}

	/**
	 * Run any shell command
	 * @param string $command
	 * @param bool $printOutput
	 * @param string $cwd
	 * @param array $env
	 * @param string $input
	 * @param int $timeout
	 * @param array $options
	 * @return Action
	 */
	public function runCommand($command, $printOutput = false, $cwd = null, array $env = null, $input = null, $timeout = 60, array $options = [])
	{
		return $this->addAction(new RunCommand($command, $printOutput, $cwd, $env, $input, $timeout, $options));
	}

	/**
	 * Create new mysql database
	 * @param string $user
	 * @param string $password
	 * @param string $dbName
	 * @return Action
	 */
	public function createDatabaseMysql($user, $password, $dbName)
	{
		return $this->addAction(new CreateDatabaseMysql($user, $password, $dbName));
	}

	/**
	 * Drop mysql database
	 * @param string $user
	 * @param string $password
	 * @param string $dbName
	 * @return Action
	 */
	public function dropDatabaseMysql($user, $password, $dbName)
	{
		return $this->addAction(new DropDatabaseMysql($user, $password, $dbName));
	}

	/**
	 * Execute composer update
	 * @param string $dir
	 * @return Action
	 */
	public function composerUpdate($dir)
	{
		return $this->addAction(new UpdateComposer($dir));
	}

	/**
	 * Execute composer install
	 * @param string $dir
	 * @return Action
	 */
	public function composerInstall($dir)
	{
		return $this->addAction(new InstallComposer($dir));
	}
}
