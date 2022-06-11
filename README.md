
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Extract text from a pdf

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/pdf-to-text.svg?style=flat-square)](https://packagist.org/packages/spatie/pdf-to-text)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spatie/pdf-to-text/run-tests?label=tests)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/pdf-to-text.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/pdf-to-text)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/pdf-to-text.svg?style=flat-square)](https://packagist.org/packages/spatie/pdf-to-text)

This package provides a class to extract text from a pdf.

```php
use Spatie\PdfToText\Pdf;

echo Pdf::getText('book.pdf'); //returns the text from the pdf
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/pdf-to-text.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/pdf-to-text)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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

On a mac you can install the binary using brew

```bash
brew install poppler
```

If you're on RedHat, CentOS, Rocky Linux or Fedora use this:

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

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
