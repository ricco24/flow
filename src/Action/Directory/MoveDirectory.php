<?php

namespace Kelemen\Flow\Action\Directory;

use Kelemen\Flow\Action\Action;
use Kelemen\Flow\Renderer\Renderer;

class MoveDirectory extends Action
{
    /** @var string */
    private $oldDirName;

    /** @var string */
    private $newDirName;

    public function __construct(string $oldDirName, string $newDirName)
    {
        $this->oldDirName = $oldDirName;
        $this->newDirName = $newDirName;
    }

    public function run(Renderer $renderer): void
    {
        $renderer->writeln($this,
            'Moving directory '.$renderer->highlight($this->oldDirName).' to '.$renderer->highlight($this->newDirName));

        if (!is_dir($this->newDirName)) {
            $renderer->writeError($this, 'Directory '.$renderer->highlight($this->oldDirName).' does not exists');
            return;
        }

        if (is_dir($this->newDirName)) {
            $renderer->writeError($this, 'Directory '.$renderer->highlight($this->newDirName).' already exists');
            return;
        }

        @rename($this->oldDirName, $this->newDirName)
            ? $renderer->writeSuccess($this,
            'Directory moved from '.$renderer->highlight($this->oldDirName).' to '.$renderer->highlight($this->newDirName))
            : $renderer->writeError($this, 'Directory '.$renderer->highlight($this->oldDirName).' failed to move');
    }
}
