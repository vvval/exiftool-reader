# Exiftool reader process wrapper
A PHP wrapper to fetch data from `exiftools` util.

[![Latest Stable Version](https://poser.pugx.org/vvval/exiftool-reader/v/stable)](https://packagist.org/packages/vvval/exiftool-reader) 
[![Total Downloads](https://poser.pugx.org/vvval/exiftool-reader/downloads)](https://packagist.org/packages/vvval/exiftool-reader) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/vvval/exiftool-reader/badges/quality-score.png)](https://scrutinizer-ci.com/g/vvval/exiftool-reader) 
[![Build Status](https://travis-ci.org/vvval/exiftool-reader.svg?branch=master)](https://travis-ci.org/vvval/exiftool-reader)

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