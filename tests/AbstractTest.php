<?php

namespace ExiftoolReader\Tests;

use ExiftoolReader\Command;
use ExiftoolReader\Config\Exiftool;
use ExiftoolReader\Config\Mapper;
use ExiftoolReader\Metadata;
use ExiftoolReader\Reader;
use ExiftoolReader\Utils;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Factory.
     * todo Replace with DI container.
     *
     * @return mixed
     */
    protected function makeClass()
    {
        $args = func_get_args();
        if (count($args) < 1) {
            throw new \PHPUnit_Framework_ExpectationFailedException(
                sprintf('Class name is required')
            );
        }

        $class = array_shift($args);

        if (!class_exists($class)) {
            throw new \PHPUnit_Framework_ExpectationFailedException(
                sprintf('Unable to find %s class', $class)
            );
        }

        if (count($args) == 0) {
            $object = new $class;
        } else {
            $reflection = new \ReflectionClass($class);
            $object = $reflection->newInstanceArgs($args);
        }

        return $object;
    }

    /**
     * Get filename by relative name.
     *
     * @param string $filename
     * @return string
     */
    protected function filename($filename)
    {
        return dirname(__FILE__) . '/' . $filename;
    }

    /**
     * @return Exiftool
     */
    protected function makeExiftool()
    {
        return $this->makeClass(Exiftool::class);
    }

    /**
     * @return Command
     */
    protected function makeCommand()
    {
        return $this->makeClass(Command::class, $this->makeExiftool());
    }

    /**
     * @return Utils
     */
    protected function makeUtils()
    {
        return $this->makeClass(Utils::class);
    }

    /**
     * @return Mapper
     */
    protected function makeMapper()
    {
        return $this->makeClass(Mapper::class);
    }

    /**
     * @return Reader
     */
    protected function makeReader()
    {
        return $this->makeClass(Reader::class, $this->makeExiftool(), $this->makeCommand());
    }

    /**
     * @return Metadata
     */
    protected function makeMetadata()
    {
        return $this->makeClass(Metadata::class, $this->makeMapper(), $this->makeUtils());
    }
}