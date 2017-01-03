<?php

namespace ExiftoolReader\Config;

class Mapper extends AbstractConfig
{
    /**
     * Config.
     *
     * @var array
     */
    protected $config = [
        'title'       => ['Title', 'ObjectName'],
        'description' => ['Description', 'Caption-Abstract', 'ImageDescription'],
        'keywords'    => ['Keywords', 'Subject'],
    ];

    /**
     * Get metadata aliases.
     *
     * @param string $name
     * @return array
     */
    public function getAliases($name)
    {
        foreach ($this->config as $key => $value) {
            if (strcasecmp($key, $name) === 0) {
                return $value;
            }
        }

        return [$name];
    }
}