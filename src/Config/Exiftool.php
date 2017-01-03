<?php

namespace ExiftoolReader\Config;

/**
 * Class Config
 */
class Exiftool extends AbstractConfig
{
    /**
     * Config.
     *
     * @var array
     */
    protected $config = [
        'path'    => '/usr/bin/exiftool',
        'command' => 'exiftool -j %s',
    ];

    /**
     * Get exiftool read command.
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->config['command'];
    }

    /**
     * Where the exiftool is.
     *
     * @return string
     */
    public function path()
    {
        return $this->config['path'];
    }
}