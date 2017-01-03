<?php

namespace ExiftoolReader;

use ExiftoolReader\Config\Mapper;

/**
 * Class Metadata
 */
class Metadata
{
    /**
     * @var Mapper
     */
    private $config;

    /**
     * @var Utils
     */
    private $utils;

    /**
     * Metadata constructor.
     *
     * @param Mapper $config
     * @param Utils          $utils
     */
    public function __construct(Mapper $config, Utils $utils)
    {
        $this->config = $config;
        $this->utils = $utils;
    }

    /**
     * Fetch metadata by provided keys.
     *
     * @param Result $input
     * @param array  $keys
     * @return array
     */
    public function fetch(Result $input, array $keys)
    {
        $output = [];

        foreach ($keys as $key) {
            $fetched = $this->utils->fetchKeys(
                $input->getDecoded(),
                $this->config->getAliases($key)
            );

            foreach ($fetched as $name => $value) {
                if (!empty($value)) {
                    //Get first not-empty value.
                    $output[$key] = $value;

                    continue;
                }
            }
        }

        return $output;
    }
}