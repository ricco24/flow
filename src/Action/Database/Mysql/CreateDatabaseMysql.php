<?php

namespace Kelemen\Flow\Action\Database\Mysql;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class CreateDatabaseMysql extends Action
{
	/** @var string */
	private $user;

	/** @var string */
	private $password;

	/** @var string */
	private $dbName;

	/**
	 * @param string $user
	 * @param string $password
	 * @param string $dbName
	 */
	public function __construct($user, $password, $dbName)
	{
		$this->user = $user;
		$this->password = $password;
		$this->dbName = $dbName;
	}

	/**
	 * @param OutputInterface $output
	 * @param Renderer $renderer
	 */
	public function run(OutputInterface $output, Renderer $renderer)
	{
		$renderer->writeln($output, 'Creating MySQL database ' . $renderer->highlight($this->dbName));
		$process = new Process('mysql -u ' . $this->user  . ' -p' . $this->password . ' -e "CREATE DATABASE ' . $this->dbName . '"');
		$process->run();

		if ($process->isSuccessful()) {
			$renderer->writeSuccess($output, 'MySQL database ' . $renderer->highlight($this->dbName) . ' was created');
			return;
		}

		$renderer->writeError($output, 'MySQL database ' . $renderer->highlight($this->dbName) . ' was not created');
		$renderer->writeError($output, 'Reason: ' . $process->getErrorOutput());
	}
}