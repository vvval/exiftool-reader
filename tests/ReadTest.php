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

        /**
         * Not in /usr/bin/exiftool? add own location like
         * $config->mergeConfig(['path' => 'C:\exiftool']);
         */

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
     * Test Command class
     *
     * @depends testHasTestAsset
     */
    public function testCommandComponent()
    {
        $filename = 'some test filename';
        $this->assertContains($filename, $this->makeCommand()->build($filename));
    }

    /**
     * Test Utils class
     *
     * @depends testHasTestAsset
     */
    public function testUtilsComponent()
    {
        $input = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3',
            'value3'
        ];
        $utils = $this->makeUtils();

        /**
         * test case-sensitive key fetching
         */
        $this->assertEquals(['key1' => 'value1'], $utils->fetchKeys($input, ['key1']));
        $this->assertNotEquals(['key1' => 'value1'], $utils->fetchKeys($input, ['kEy1']));

        /**
         * Test only presented keys are in the output
         */
        $this->assertEquals(['key1' => 'value1'], $utils->fetchKeys($input, ['key1', 'key4']));
    }

    /**
     * Test Mapper class
     *
     * @depends testHasTestAsset
     */
    public function testMapperComponent()
    {
        $mapper = $this->makeMapper();
        $mapper->mergeConfig([
            'some test'  => ['Some test1', 'Some test2'],
            'some test2' => ['title']
        ]);

        /**
         * Test if no aliases - given key will be returned
         */
        $this->assertEquals(['test'], $mapper->getAliases('test'));

        /**
         * Test correct aliasing.
         */
        $this->assertEquals(['title'], $mapper->getAliases('some test2'));

        /**
         * Test case-insensitive alias search.
         */
        $this->assertEquals(['Some test1', 'Some test2'], $mapper->getAliases('some test'));
        $this->assertEquals(['Some test1', 'Some test2'], $mapper->getAliases('sOmE TeSt'));

        /**
         * Test case-sensitive aliases result.
         */
        $this->assertNotEquals(['some test1', 'Some test2'], $mapper->getAliases('sOmE TeSt'));
    }

    /**
     * Test Result class
     *
     * @depends testHasTestAsset
     */
    public function testResultComponent()
    {
        /**
         * Test json_decoded string is converted to array and "0"-key value is returned
         */
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

    /**
     * Test Reader class.
     *
     * @depends testCommandComponent
     * @depends testUtilsComponent
     * @depends testMapperComponent
     * @depends testResultComponent
     */
    public function testReader()
    {
        $reader = $this->makeReader();
        $result = $reader->read($this->filename($this->asset));

        /**
         * Test correct output
         */
        $this->assertInstanceOf(Result::class, $result);
    }

    /**
     * Test Metadata reader.
     *
     * @depends testReader
     */
    public function testMetadata()
    {
        $mapper = $this->makeMapper();
        $mapper->mergeConfig([
            'field1' => ['Title'],
            'field2' => ['YCbCrPositioning']
        ]);

        $reader = $this->makeReader();
        $metadata = $this->makeMetadata($mapper);
        $result = $reader->read($this->filename($this->asset));

        /**
         * Test both alias fields have values in metadata and they are presented in output.
         * "Title" and "ObjectName" are both presented in metadata and in fetch-keys.
         */
        $this->assertEquals(['title' => 'some title'], $metadata->fetch($result, ['title']));
        $this->assertEquals(
            ['ObjectName' => 'some object name'],
            $metadata->fetch($result, ['ObjectName'])
        );
        $this->assertEquals(
            ['Title' => 'some title', 'ObjectName' => 'some object name'],
            $metadata->fetch($result, ['Title', 'ObjectName'])
        );

        /**
         * test callbacks
         */
        $this->assertEquals(
            ['TITLE' => 'Some Title'],
            $metadata->fetch($result, ['title'], 'strtoupper', 'ucwords')
        );

        /**
         * Test field not presented in metadata and having an alias will have its value in output.
         */
        $this->assertEquals(
            ['field1' => 'some title', 'field2' => 'Centered'],
            $metadata->fetch($result, ['field1', 'field2'])
        );
    }
}