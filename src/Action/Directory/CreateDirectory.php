<?php

namespace Kelemen\Flow\Action\Directory;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;

class CreateDirectory extends Action
{
    /** @var string */
    private $dir;

    /** @var int */
    private $mode;

    /** @var bool */
    private $recursive;

    /** @var bool */
    private $force;

    /** @noinspection PhpOptionalBeforeRequiredParametersInspection */
    public function __construct(string $dir, int $mode = 0777, bool $recursive, bool $force)
    {
        $this->dir = $dir;
        $this->mode = $mode;
        $this->recursive = $recursive;
        $this->force = $force;
    }

    public function run(Renderer $renderer): void
    {
        $renderer->writeln($this, 'Creating directory '.$renderer->highlight($this->dir));

        if (is_dir($this->dir)) {
            if (!$this->force) {
                $renderer->writeSkip($this, 'Directory '.$renderer->highlight($this->dir).' exists');
                return;
            }

            $this->runAction(new DeleteDirectory($this->dir), $renderer);
        }

        @mkdir($this->dir, $this->mode, $this->recursive)
            ? $renderer->writeSuccess($this, 'Directory '.$renderer->highlight($this->dir).' was created')
            : $renderer->writeError($this, 'Directory '.$renderer->highlight($this->dir).' was not created');
    }
}
