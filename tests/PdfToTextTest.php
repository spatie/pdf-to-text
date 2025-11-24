<?php

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Exception\InvalidArgumentException;
use Symfony\Component\Process\Process;

uses(PHPUnit\Framework\TestCase::class);

beforeEach(function () {
    $this->dummyPdf = __DIR__ . '/testfiles/dummy.pdf';
    $this->dummyPdfText = 'This is a dummy PDF';

    $this->pdftotextPath = PHP_OS === 'Linux'
        ? '/usr/bin/pdftotext'
        : '/opt/homebrew/bin/pdftotext';

    if (file_exists(__DIR__ . '/config.php')) {
        $config = include __DIR__ . '/config.php';

        $this->pdftotextPath = isset($config['pdftotextPath'])
            ? $config['pdftotextPath']
            : null;
    }
});

it('can extract text from a pdf', function () {
    $text = (new Pdf($this->pdftotextPath))
        ->setPdf($this->dummyPdf)
        ->text();

    expect($text)->toBe($this->dummyPdfText);
});

it('provides a static method to extract text', function () {
    expect(Pdf::getText($this->dummyPdf, $this->pdftotextPath))
        ->toBe($this->dummyPdfText);
});

it('can handle paths', function (string $path) {
    $pdfPath = __DIR__ . $path;

    expect(Pdf::getText($pdfPath, $this->pdftotextPath))->toBe($this->dummyPdfText);
})->with([
    'with spaces' => '/testfiles/dummy with spaces in its name.pdf',
    'with single quotes' => '/testfiles/dummy\'s_file.pdf',
]);

it('can handle pdftotext options', function (array $options) {
    $text = (new Pdf($this->pdftotextPath))
        ->setPdf(__DIR__ . '/testfiles/scoreboard.pdf')
        ->setOptions($options)
        ->text();

    expect($text)->toContain('Charleroi 50      28     13 11 4');
})->with([
    'without starting hyphen' => fn () => ['layout', 'f 1'],
    'with starting hyphen' => fn () => ['-layout', '-f 1'],
    'with mixed hyphen status' => fn () => ['-layout', 'f 1'],
]);

it('will throw an exception when the PDF is not found', function () {
    (new Pdf($this->pdftotextPath))
        ->setPdf('/no/pdf/here/dummy.pdf')
        ->text();
})->throws(PdfNotFound::class);

it('will throw an exception when the binary is not found', function () {
    (new Pdf('/there/is/no/place/like/home/pdftotext'))
        ->setPdf($this->dummyPdf)
        ->text();
})->throws(CouldNotExtractText::class);

it('will throw an exception when the option is unknown', function () {
    Pdf::getText($this->dummyPdf, $this->pdftotextPath, ['-foo']);
})->throws(CouldNotExtractText::class);

it('allows for options to be added programatically without overriding previously added options', function () {
    $text = (new Pdf($this->pdftotextPath))
        ->setPdf(__DIR__ . '/testfiles/multi_page.pdf')
        ->setOptions(['-layout', '-f 2'])
        ->addOptions(['-l 2'])
        ->text();

    expect($text)->toContain('This is page 2')
        ->not->toContain('This is page 1', 'This is page 3');
});

it('will throw an exception when timeout is a negative number', function () {
    (new Pdf($this->pdftotextPath))
        ->setPdf($this->dummyPdf)
        ->setTimeout(-1)
        ->text();
})->throws(InvalidArgumentException::class);

it('can handle symfony process by callback', function () {
    $text = (new Pdf('pdftotext'))
        ->setPdf($this->dummyPdf)
        ->text(fn (Process $process) => $process);

    expect($text)->toBe($this->dummyPdfText);
});

it('can handle symfony process by callback using a static method', function () {
    $text = Pdf::getText($this->dummyPdf, 'pdftotext', [], 60, fn (Process $process) => $process);

    expect($text)->toBe($this->dummyPdfText);
});
