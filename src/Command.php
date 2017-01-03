<?php

namespace ExiftoolReader;

use ExiftoolReader\Config\Exiftool;

/**
 * Class Command
 */
class Command
{
    /**
     * @var Exiftool
     */
    private $config;

    /**
     * Reader constructor.
     *
     * @param Exiftool $config
     */
    public function __construct(Exiftool $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function build($filename)
    {
        return sprintf($this->config->getCommand(), $filename);
    }
}