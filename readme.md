# Exiftool reader process wrapper
A PHP wrapper to fetch data from `exiftools` util.

[![Latest Stable Version](https://poser.pugx.org/spiral/snapshotter/v/stable)](https://packagist.org/packages/vvval/exiftool-reader) 
[![Total Downloads](https://poser.pugx.org/spiral/snapshotter/downloads)](https://packagist.org/packages/vvval/exiftool-reader) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/spiral-modules/snapshotter/badges/quality-score.png)](https://scrutinizer-ci.com/g/vvval/exiftool-reader) 

## Installation
```
composer require vvval/exiftool-reader
```

## Example usage
```php
<?php
/**
 * @var ExiftoolReader\Reader $reader
 * @var ExiftoolReader\Result $output
 * @var ExiftoolReader\Metadata $metadata
 */
$output = $reader->read('filename');

/**
 * @var array $decoded Full metadata array
 */
$decoded = $output->getDecoded();

$keys = ['title', 'description'];

/**
 * @var array $fetchedData Fetched metadata keys.
 * Uses aliases to find values, for example Title|ObjectName, Description|Caption-Abstract|ImageDescription, etc.
 */
$fetchedData = $metadata->fetch($output, $keys);
```