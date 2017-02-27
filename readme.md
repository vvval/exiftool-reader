# Exiftool reader process wrapper
A PHP wrapper to fetch data from `exiftools` util.

[![Latest Stable Version](https://poser.pugx.org/vvval/exiftool-reader/v/stable)](https://packagist.org/packages/vvval/exiftool-reader) 
[![Total Downloads](https://poser.pugx.org/vvval/exiftool-reader/downloads)](https://packagist.org/packages/vvval/exiftool-reader) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vvval/exiftool-reader/badges/quality-score.png)](https://scrutinizer-ci.com/g/vvval/exiftool-reader) 
[![Build Status](https://travis-ci.org/vvval/exiftool-reader.svg?branch=master)](https://travis-ci.org/vvval/exiftool-reader)
[![License](https://poser.pugx.org/vvval/exiftool-reader/license)](https://packagist.org/packages/vvval/exiftool-reader)
[![Coverage Status](https://coveralls.io/repos/github/vvval/exiftool-reader/badge.svg?branch=master)](https://coveralls.io/github/vvval/exiftool-reader?branch=master)
## Installation
```
composer require vvval/exiftool-reader
```

## Example usage
```php
<?php
$exiftoolConfig = new \ExiftoolReader\Config\Exiftool();
$command = new \ExiftoolReader\Command($exiftoolConfig);
$mapperConfig = new \ExiftoolReader\Config\Mapper();
$utils = new \ExiftoolReader\Utils();

$reader = new \ExiftoolReader\Reader($command);
$metadata = new \ExiftoolReader\Metadata($mapperConfig, $utils);

/** @var ExiftoolReader\Result $output */
$output = $reader->read('filename');

/**
 * Full metadata array.
 */
$decoded = $output->getDecoded();
var_dump($decoded); // ['title' => '...', 'description' => '...', /* ... other fields */]

/**
 * Fetched specified metadata keys.
 * Uses aliases to find values,
 * for example Title|ObjectName, Description|Caption-Abstract|ImageDescription, etc...
 */
$fetchedData = $metadata->fetch($output, ['title', 'description']);
var_dump($fetchedData); // ['title' => '...', 'description' => '...']
```
