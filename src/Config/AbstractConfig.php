<?php

namespace ExiftoolReader\Config;

/**
 * Class AbstractConfig
 *
 * @package Config
 */
abstract class AbstractConfig
{
    /**
     * Config.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            $this->setConfig($config);
        }
    }

    /**
     * Set new config value.
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Merge configs.
     *
     * @param array $config
     */
    public function mergeConfig(array $config)
    {
        $this->config = array_replace_recursive($this->config, $config);
    }
}