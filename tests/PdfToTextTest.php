<?php

namespace Spatie\PdfToText\Test;

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;

class PdfToTextTest extends \PHPUnit_Framework_TestCase
{
    protected $dummyPdf = __DIR__.'/testfiles/dummy.pdf';
    protected $dummyPdfText = 'This is a dummy PDF';

    /** @test */
    public function it_can_extract_text_from_a_pdf()
    {
        $text = (new Pdf())
            ->setPdf($this->dummyPdf)
            ->text();

        $this->assertSame($this->dummyPdfText, $text);
    }

    /** @test */
    public function it_provides_a_static_method_to_extract_text()
    {
        $this->assertSame($this->dummyPdfText, Pdf::getText($this->dummyPdf));
    }

    /** @test */
    public function it_can_hande_paths_with_spaces()
    {
        $pdfPath = __DIR__.'/testfiles/dummy with spaces in its name.pdf';

        $this->assertSame($this->dummyPdfText, Pdf::getText($pdfPath));
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_pdf_is_not_found()
    {
        $this->setExpectedException(PdfNotFound::class);

        (new Pdf())
            ->setPdf('/no/pdf/here/dummy.pdf')
            ->text();
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_binary_is_not_found()
    {
        $this->setExpectedException(CouldNotExtractText::class);

        (new Pdf('/there/is/no/place/like/home/pdftotext'))
            ->setPdf($this->dummyPdf)
            ->text();
    }
}
