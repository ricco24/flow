<?php

namespace Kelemen\Flow\Action\Command;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;
use Symfony\Component\Process\Process;

class RunCommand extends Action
{
    /** @var string */
    private $command;

    /** @var bool */
    private $printOutput;

    /** @var string */
    private $cwd;

    /** @var array */
    private $env;

    /** @var string */
    private $input;

    /** @var int */
    private $timeout;

    public function __construct(
        string $command,
        bool $printOutput,
        string $cwd = null,
        array $env = null,
        string $input = null,
        int $timeout = 60
    ) {
        $this->command = $command;
        $this->printOutput = $printOutput;
        $this->cwd = $cwd;
        $this->env = $env;
        $this->input = $input;
        $this->timeout = $timeout;
    }

    public function run(Renderer $renderer): void
    {
        $renderer->writeln($this, 'Executing command '.$renderer->highlight($this->command));
        $process = Process::fromShellCommandline($this->command, $this->cwd, $this->env, $this->input, $this->timeout);

        $callback = $this->printOutput
            ? function ($type, $buffer) use ($renderer) {
                static $data;

                if ($buffer !== PHP_EOL) {
                    $data .= $buffer;
                    return;
                }

                $renderer->writeln($this, $data, 1);
                $data = '';
            }
            : null;

        $process->run($callback);

        if ($process->isSuccessful()) {
            $renderer->writeSuccess($this, 'Command '.$renderer->highlight($this->command).' was executed');
            return;
        }

        $renderer->writeError($this, 'Command '.$renderer->highlight($this->command).' was not executed');
        $renderer->writeError($this, 'Reason: '.$process->getErrorOutput());
    }
}
