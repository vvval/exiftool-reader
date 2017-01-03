<?php

namespace ExiftoolReader;

use ExiftoolReader\Config\Exiftool;
use Symfony\Component\Process\Process;

/**
 * Class Reader
 */
class Reader
{
    /**
     * @var Command
     */
    private $command;

    /**
     * Reader constructor.
     *
     * @param Exiftool $config
     * @param Command         $command
     */
    public function __construct(Exiftool $config, Command $command)
    {
        $this->command = $command;
    }

    /**
     * @param string $filename
     * @return Result
     */
    public function read($filename)
    {
        $process = new Process($this->command->build($filename));
        $process->run();

        return new Result($process->getOutput());
    }
}