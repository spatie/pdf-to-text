# Extract text from a pdf

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/pdf-to-text.svg?style=flat-square)](https://packagist.org/packages/spatie/pdf-to-text)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/pdf-to-text/master.svg?style=flat-square)](https://travis-ci.org/spatie/pdf-to-text)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/pdf-to-text.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/pdf-to-text)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/pdf-to-text.svg?style=flat-square)](https://packagist.org/packages/spatie/pdf-to-text)

This package provides a class to extract text from a pdf.

```php
use Spatie\PdfToText\Pdf;

echo Pdf::getText('book.pdf'); //returns the text from the pdf
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment you are required to send us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Requirements

Behind the scenes this package leverages [pdftotext](https://en.wikipedia.org/wiki/Pdftotext). You can verify if the binary installed on your system by issueing this command:

```bash
which pdftotext
```

If it is installed it will return the path to the binary.

To install the binary you can use this command on Ubuntu or Debian:

```bash
apt-get install poppler-utils
```

If you're on RedHat or CentOS use this:

```bash
yum install poppler-utils
```

## Installation

You can install the package via composer:

```bash
composer require spatie/pdf-to-text
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
echo Pdf::getText('book.pdf');
```

By default the package will assume that the `pdftotext` command is located at `/usr/bin/pdftotext`.
If it is located elsewhere pass its binary path to constructor

```php
$text = (new Pdf('/custom/path/to/pdftotext'))
    ->setPdf('book.pdf')
    ->text();
```

or as the second parameter to the `getText` static method:

```php
echo Pdf::getText('book.pdf', '/custom/path/to/pdftotext');
```

Sometimes you may want to use [pdftotext options](https://linux.die.net/man/1/pdftotext). To do so you can set them up using the `setOptions` method.

```php
$text = (new Pdf())
    ->setPdf('table.pdf')
    ->setOptions(['layout', 'r 96'])
    ->text()
;
```

or as the third parameter to the `getText` static method:

```php
echo Pdf::getText('book.pdf', null, ['layout', 'opw myP1$$Word']);
```

Please note that successive calls to `setOptions()` will overwrite options passed in during previous calls. 

If you need to make multiple calls to add options (for example if you need to pass in default options when creating 
the `Pdf` object from a container, and then add context-specific options elsewhere), you can use the `addOptions()` method:
 
 ```php
 $text = (new Pdf())
     ->setPdf('table.pdf')
     ->setOptions(['layout', 'r 96'])
     ->addOptions(['f 1'])
     ->text()
 ;
 ```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Testing

```bash
 composer test
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
