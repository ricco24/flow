<?php

namespace Kelemen\Flow\Action\Composer;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Action\Command\RunCommand;
use Kelemen\Flow\Renderer\Renderer;

class UpdateComposer extends Action
{
    /** @var string */
    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function run(Renderer $renderer): void
    {
        $this->runAction(new RunCommand('cd '.$this->dir.' && composer update', true, null, null, null, 1800),
            $renderer);
    }
}
