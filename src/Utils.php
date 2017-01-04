<?php

namespace ExiftoolReader;

use Symfony\Component\Process\ProcessUtils;

/**
 * Class Utils
 */
class Utils
{
    /**
     * Escape shell arguments.
     *
     * @param string $args
     * @return string
     */
    public function escapeArgs($args)
    {
        return ProcessUtils::escapeArgument($args);
    }

    /**
     * Fetch array values by provided keys.
     * If no value for one of provided keys - key will be skipped.
     *
     * @param array $array
     * @param array $keys
     * @return array
     */
    public function fetchKeys(array $array, array $keys)
    {
        return array_intersect_key($array, array_flip($keys));
    }
}