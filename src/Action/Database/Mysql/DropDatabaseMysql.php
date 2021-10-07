<?php

namespace Kelemen\Flow\Action\Database\Mysql;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Process\Process;

class DropDatabaseMysql extends Action
{
    /** @var string */
    private $user;

    /** @var string */
    private $password;

    /** @var string */
    private $dbName;

    public function __construct(string $user, string $password, string $dbName)
    {
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    public function run(Renderer $renderer)
    {
        $renderer->writeln($this, 'Dropping MySQL database '.$renderer->highlight($this->dbName));
        $process = Process::fromShellCommandline('mysql -u '.$this->user.' -p'.$this->password.' -e "DROP DATABASE IF EXISTS '.$this->dbName.'"');
        $process->run();

        if ($process->isSuccessful()) {
            $renderer->writeSuccess($this, 'MySQL database '.$renderer->highlight($this->dbName).' was dropped');
            return;
        }

        $renderer->writeError($this, 'MySQL database '.$renderer->highlight($this->dbName).' was not dropped');
        $renderer->writeError($this, 'Reason: '.$process->getErrorOutput());
    }
}
