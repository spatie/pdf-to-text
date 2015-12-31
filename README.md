# Extract text from a pdf

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/pdf-to-text.svg?style=flat-square)](https://packagist.org/packages/spatie/pdf-to-text)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/pdf-to-text/master.svg?style=flat-square)](https://travis-ci.org/spatie/pdf-to-text)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/9d85e8dd-b444-4bef-a5d5-faa7f2d8d6bb.svg?style=flat-square)](https://insight.sensiolabs.com/projects/9d85e8dd-b444-4bef-a5d5-faa7f2d8d6bb)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/pdf-to-text.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/pdf-to-text)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/pdf-to-text.svg?style=flat-square)](https://packagist.org/packages/spatie/pdf-to-text)

This package provides a class to extract text from a pdf.

```php
 \Spatie\PdfToText\Pdf::getText('book.pdf'); //returns the text from the pdf
```


Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Requirements

Behind the scenes this package leverages [pdftotext](https://en.wikipedia.org/wiki/Pdftotext). You can verify if the binary installed on your system by issueing this command:
```
which pdftotext
```

If it is installed it will return the path to the binary.

To install the binary you can use this command on Ubuntu or Debian:

```php
apt-get install poppler-utils
```

If you're on RedHat or CentOS use this:

```bash
yum install poppler-utils
```

## Installation

You can install the package via composer:
```bash
$ composer require spatie/pdf-to-text
```

## Usage

Extracting text from a pdf is easy.

```php
$text = (new Pdf())
    ->setPdf('book.pdf')
    ->text();
```

Or easier:

```php
 \Spatie\PdfToText\Pdf::getText('book.pdf')
```

By default the package will assume that the `pdftotext` is located at `/usr/bin/pdftotext`.
If you're using the a different location pass the path to the binary in constructor
```php
$text = (new Pdf('/custom/path/to/pdftotext'))
    ->setPdf('book.pdf')
    ->text();
```

or as the second parameter to the `getText`-function:
```php
 \Spatie\PdfToText\Pdf::getText('book.pdf', '/custom/path/to/pdftotext')
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
