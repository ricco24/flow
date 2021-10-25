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

    public function __construct(Renderer $renderer = null)
    {
        $this->renderer = $renderer ?: new DefaultRenderer();
    }

    /**
     * @template T of Action
     * @param T $action
     * @return T
     */
    public function addAction(Action $action): Action
    {
        $this->actions[] = $action;
        return $action;
    }

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

    /* @noinspection PhpOptionalBeforeRequiredParametersInspection */
    public function createDirectory(string $dir, int $mode = 0777, bool $recursive): CreateDirectory
    {
        return $this->addAction(new CreateDirectory($dir, $mode, $recursive));
    }

    /**
     * Create new directory, delete if already exists
     * @param string $dir
     * @param int    $mode
     * @param bool   $recursive
     * @return CreateDirectory
     * @noinspection PhpOptionalBeforeRequiredParametersInspection
     */
    public function createDirectoryForce(string $dir, int $mode = 0777, bool $recursive): CreateDirectory
    {
        return $this->addAction(new CreateDirectory($dir, $mode, $recursive, true));
    }

    public function deleteDirectory(string $dir): DeleteDirectory
    {
        return $this->addAction(new DeleteDirectory($dir));
    }

    /**
     * Move directory to new destination
     * @param string $oldDirName
     * @param string $newDirName
     * @return MoveDirectory
     */
    public function moveDirectory(string $oldDirName, string $newDirName): MoveDirectory
    {
        return $this->addAction(new MoveDirectory($oldDirName, $newDirName));
    }

    /**
     * Run any shell command
     * @param string      $command
     * @param bool        $printOutput
     * @param string|null $cwd
     * @param array|null  $env
     * @param string|null $input
     * @param int         $timeout
     * @return RunCommand
     */
    public function runCommand(
        string $command,
        bool $printOutput = false,
        string $cwd = null,
        array $env = null,
        string $input = null,
        int $timeout = 60
    ): RunCommand {
        return $this->addAction(new RunCommand($command, $printOutput, $cwd, $env, $input, $timeout));
    }

    /**
     * Create new mysql database
     * @param string $user
     * @param string $password
     * @param string $dbName
     * @return CreateDatabaseMysql
     */
    public function createDatabaseMysql(string $user, string $password, string $dbName): CreateDatabaseMysql
    {
        return $this->addAction(new CreateDatabaseMysql($user, $password, $dbName));
    }

    /**
     * Drop mysql database
     * @param string $user
     * @param string $password
     * @param string $dbName
     * @return DropDatabaseMysql
     */
    public function dropDatabaseMysql(string $user, string $password, string $dbName): DropDatabaseMysql
    {
        return $this->addAction(new DropDatabaseMysql($user, $password, $dbName));
    }

    /**
     * Execute composer update
     * @param string $dir
     * @return UpdateComposer
     */
    public function composerUpdate(string $dir): UpdateComposer
    {
        return $this->addAction(new UpdateComposer($dir));
    }

    /**
     * Execute composer install
     * @param string $dir
     * @return InstallComposer
     */
    public function composerInstall(string $dir): InstallComposer
    {
        return $this->addAction(new InstallComposer($dir));
    }
}
