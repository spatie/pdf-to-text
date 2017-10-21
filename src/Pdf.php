<?php

namespace Spatie\PdfToText;

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Symfony\Component\Process\Process;

class Pdf
{
    protected $pdf;

    protected $binPath;
    protected $binInfoPath;

    public function __construct(string $binPath = null)
    {
        $this->binPath = $binPath ?? '/usr/bin/pdftotext';
        $this->binInfoPath = $binInfoPath ?? '/usr/bin/pdfinfo';
    }

    public function setPdf(string $pdf) : Pdf
    {
        if (!file_exists($pdf)) {
            throw new PdfNotFound("could not find pdf {$pdf}");
        }

        $this->pdf = $pdf;

        return $this;
    }

    public function totalPagesCount():int
    {
        $process = new Process("{$this->binInfoPath} '{$this->pdf}' | grep 'Pages:' -");
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CouldNotExtractText($process);
        }

		$pages = trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
		$pages = trim(str_replace('Pages:','',$pages));
        return $pages+0;
    }


    public function text(int $pageFrom = null, int $pageTo = null) : string
    {
		$params = "";

		if (isset($pageFrom) && isset($pageTo)){
			
			$params .= " -f " . $pageFrom;
			$params .= " -l " . $pageTo;
		} 
		
        $process = new Process("{$this->binPath} '{$this->pdf}' " . $params . " -");
        $process->run();

        if (!$process->isSuccessful()) {
            throw new CouldNotExtractText($process);
        }

        return trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
    }

    public static function getText(string $pdf, string $binPath = null) : string
    {
        return (new static($binPath))
            ->setPdf($pdf)
            ->text();
    }
}