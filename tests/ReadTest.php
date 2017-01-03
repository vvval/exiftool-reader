<?php

namespace ExiftoolReader\Tests;

use ExiftoolReader\Result;

/**
 * Class ReadTest
 *
 * @package ExiftoolReader\Tests
 */
class ReadTest extends AbstractTest
{
    /**
     * Test image asset file.
     *
     * @var string
     */
    private $asset = 'assets/asset.jpg';

    /**
     * If exiftool is enabled.
     */
    public function testEnabled()
    {
        $config = $this->makeExiftool();

        //Not in /usr/bin/exiftool? add own location like
        //$config->mergeConfig(['path' => 'C:\exiftool']);

        $this->assertFileExists($config->path());
    }

    /**
     * If test asset file exists.
     *
     * @depends testEnabled
     */
    public function testHasTestAsset()
    {
        $this->assertFileExists($this->filename($this->asset));
    }

    /**
     * Test separate components.
     *
     * @depends testHasTestAsset
     */
    public function testComponents()
    {
        $this->commandComponentTesting();
        $this->utilsComponentTesting();
        $this->mapperComponentTesting();
        $this->resultComponentTesting();
    }

    /**
     * Test Reader class.
     *
     * @depends testComponents
     */
    public function testReader()
    {
        $reader = $this->makeReader();
        $result = $reader->read($this->filename($this->asset));

        $this->assertInstanceOf(Result::class, $result);
    }

    /**
     * Test Metadata reader.
     *
     * @depends testComponents
     */
    public function testMetadata()
    {
        $reader = $this->makeReader();
        $metadata = $this->makeMetadata();
        $result = $reader->read($this->filename($this->asset));

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(['title' => 'some title'], $metadata->fetch($result, ['title']));
        $this->assertEquals(
            ['ObjectName' => 'some object name'],
            $metadata->fetch($result, ['ObjectName'])
        );
        $this->assertEquals(
            ['Caption-Abstract' => 'some caption abstract'],
            $metadata->fetch($result, ['Caption-Abstract'])
        );
    }

    /**
     * Test Command class
     */
    private function commandComponentTesting()
    {
        $filename = 'some test filename';
        $this->assertContains($filename, $this->makeCommand()->build($filename));
    }

    /**
     * Test Utils class
     */
    private function utilsComponentTesting()
    {
        $input = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3',
            'value3'
        ];
        $utils = $this->makeUtils();
        $this->assertEquals(['key1' => 'value1'], $utils->fetchKeys($input, ['key1']));
        $this->assertNotEquals(['key1' => 'value1'], $utils->fetchKeys($input, ['kEy1']));
    }

    /**
     * Test Mapper class
     */
    private function mapperComponentTesting()
    {
        $mapper = $this->makeMapper();
        $this->assertEquals(['test'], $mapper->getAliases('test'));

        $mapper->mergeConfig(['some test' => ['Some test1', 'Some test2']]);
        $this->assertEquals(['Some test1', 'Some test2'], $mapper->getAliases('some test'));
        $this->assertEquals(['Some test1', 'Some test2'], $mapper->getAliases('sOmE TeSt'));
    }

    /**
     * Test Result class
     */
    private function resultComponentTesting()
    {
        $result = new Result('');
        $this->assertEquals([], $result->getDecoded());

        $result = new Result('test');
        $this->assertEquals([], $result->getDecoded());

        $result = new Result('[]');
        $this->assertEquals([], $result->getDecoded());

        $result = new Result('{"testKey": "Test Value"}');
        $this->assertEquals([], $result->getDecoded());

        $result = new Result('["Test Value"]');
        $this->assertEquals('Test Value', $result->getDecoded());

        $result = new Result('[{"testKey": "Test Value"}]');
        $this->assertEquals(['testKey' => 'Test Value'], $result->getDecoded());
    }
}