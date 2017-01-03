<?php

namespace ExiftoolReader;

/**
 * Class Result
 */
class Result
{
    /**
     * Input data.
     *
     * @var string
     */
    private $raw;

    /**
     * Decoded data.
     *
     * @var array
     */
    private $decoded = [];

    /**
     * Result constructor.
     *
     * @param string $raw
     */
    public function __construct($raw)
    {
        $this->raw = $raw;
        $this->decoded = $this->decode($raw);
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @return array
     */
    public function getDecoded()
    {
        return $this->decoded;
    }

    /**
     * Decode json encoded string.
     *
     * @param string $raw
     * @return array
     */
    private function decode($raw)
    {
        $decoded = json_decode($raw, true);

        if (!empty($decoded[0])) {
            return $decoded[0];
        }

        return [];
    }
}