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
     * @param Utils  $utils
     */
    public function __construct(Mapper $config, Utils $utils)
    {
        $this->config = $config;
        $this->utils = $utils;
    }

    /**
     * Fetch metadata by provided keys.
     *
     * @param Result        $input
     * @param array         $keys
     * @param callable|null $keyCallback
     * @param callable|null $valueCallback
     * @return array
     */
    public function fetch(
        Result $input,
        array $keys,
        callable $keyCallback = null,
        callable $valueCallback = null
    ) {
        $output = [];

        foreach ($keys as $key) {
            $fetched = $this->utils->fetchKeys(
                $input->getDecoded(),
                $this->config->getAliases($key)
            );

            foreach ($fetched as $name => $value) {
                //Get first not-empty value.
                if (!empty($value)) {
                    if (!empty($keyCallback)) {
                        $key = call_user_func($keyCallback, $key);
                    }

                    if (!empty($valueCallback)) {
                        $value = call_user_func($valueCallback, $value);
                    }

                    $output[$key] = $value;

                    continue;
                }
            }
        }

        return $output;
    }
}