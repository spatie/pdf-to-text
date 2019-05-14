<?php

namespace Spatie\PdfToText\Test;

use PHPUnit\Framework\TestCase;
use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;

class PdfToTextTest extends TestCase
{
    protected $dummyPdf = __DIR__.'/testfiles/dummy.pdf';
    protected $dummyPdfText = 'This is a dummy PDF';

    /**
     * @var string
     */
    private $pdftotextPath;

    protected function setUp()
    {
        parent::setUp();

        if (file_exists(__DIR__ . "/config.php")) {
            $config = include __DIR__ . "/config.php";

            $this->pdftotextPath = isset($config["pdftotextPath"])
                ? $config["pdftotextPath"]
                : null;
        }
    }

    /** @test */
    public function it_can_extract_text_from_a_pdf()
    {
        $text = (new Pdf($this->pdftotextPath))
            ->setPdf($this->dummyPdf)
            ->text();

        $this->assertSame($this->dummyPdfText, $text);
    }

    /** @test */
    public function it_provides_a_static_method_to_extract_text()
    {
        $this->assertSame($this->dummyPdfText, Pdf::getText($this->dummyPdf, $this->pdftotextPath));
    }

    /** @test */
    public function it_can_handle_paths_with_spaces()
    {
        $pdfPath = __DIR__.'/testfiles/dummy with spaces in its name.pdf';

        $this->assertSame($this->dummyPdfText, Pdf::getText($pdfPath, $this->pdftotextPath));
    }

    /** @test */
    public function it_can_handle_paths_with_single_quotes()
    {
        $pdfPath = __DIR__.'/testfiles/dummy\'s_file.pdf';

        $this->assertSame($this->dummyPdfText, Pdf::getText($pdfPath, $this->pdftotextPath));
    }

    /** @test */
    public function it_can_handle_pdftotext_options_without_starting_hyphen()
    {
        $text = (new Pdf($this->pdftotextPath))
            ->setPdf(__DIR__.'/testfiles/scoreboard.pdf')
            ->setOptions(['layout', 'f 1'])
            ->text();

        $this->assertContains("Charleroi 50      28     13 11 4", $text);
    }

    /** @test */
    public function it_can_handle_pdftotext_options_with_starting_hyphen()
    {
        $text = (new Pdf($this->pdftotextPath))
            ->setPdf(__DIR__.'/testfiles/scoreboard.pdf')
            ->setOptions(['-layout', '-f 1'])
            ->text();

        $this->assertContains("Charleroi 50      28     13 11 4", $text);
    }

    /** @test */
    public function it_can_handle_pdftotext_options_with_mixed_hyphen_status()
    {
        $text = (new Pdf($this->pdftotextPath))
            ->setPdf(__DIR__.'/testfiles/scoreboard.pdf')
            ->setOptions(['-layout', 'f 1'])
            ->text();

        $this->assertContains("Charleroi 50      28     13 11 4", $text);
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_pdf_is_not_found()
    {
        $this->expectException(PdfNotFound::class);

        (new Pdf($this->pdftotextPath))
            ->setPdf('/no/pdf/here/dummy.pdf')
            ->text();
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_binary_is_not_found()
    {
        $this->expectException(CouldNotExtractText::class);

        (new Pdf('/there/is/no/place/like/home/pdftotext'))
            ->setPdf($this->dummyPdf)
            ->text();
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_option_is_unknown()
    {
        $this->expectException(CouldNotExtractText::class);
        Pdf::getText($this->dummyPdf, $this->pdftotextPath, ['-foo']);
    }

    /** @test */
    public function it_allows_for_options_to_be_added_programatically_without_overriding_previously_added_options()
    {
        $text = (new Pdf($this->pdftotextPath))
            ->setPdf(__DIR__.'/testfiles/multi_page.pdf')
            ->setOptions(['-layout', '-f 2'])
            ->addOptions(['-l 2'])
            ->text();

        $this->assertContains("This is page 2", $text);
        $this->assertNotContains("This is page 1", $text);
        $this->assertNotContains("This is page 3", $text);
    }
}
