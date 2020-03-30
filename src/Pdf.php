<?php

namespace Spatie\PdfToText;

use Spatie\PdfToText\Exceptions\CouldNotExtractText;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Symfony\Component\Process\Process;

class Pdf
{
    protected $pdf;
    
    protected $binPath;
    
    protected $options = [];
    
    public function __construct(string $binPath = null) {
        $this->binPath = $binPath ?? '/usr/bin/pdftotext';
    }
    
    /**
     * @param string $pdf
     *
     * @return $this
     * @throws PdfNotFound
     */
    public function setPdf(string $pdf): self {
        if(!is_readable($pdf)) {
            throw new PdfNotFound("Could not read `{$pdf}`");
        }
        
        $this->pdf = $pdf;
        
        return $this;
    }
    
    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): self {
        $this->options = $this->parseOptions($options);
        
        return $this;
    }
    
    /**
     * @param array $options
     *
     * @return $this
     */
    public function addOptions(array $options): self {
        $this->options = array_merge(
            $this->options,
            $this->parseOptions($options)
        );
        
        return $this;
    }
    
    /**
     * @param array $options
     *
     * @return array
     */
    protected function parseOptions(array $options): array {
        $mapper = function(string $content): array {
            $content = trim($content);
            if('-' !== ($content[0] ?? '')) {
                $content = '-' . $content;
            }
            
            return explode(' ', $content, 2);
        };
        
        $reducer = function(array $carry, array $option): array {
            return array_merge($carry, $option);
        };
        
        return array_reduce(array_map($mapper, $options), $reducer, []);
    }
    
    /**
     * @return string
     */
    public function text(): string {
        /*_WINDOWS FIX */
        // Check if the OS is set, check if it's windows
        if(isset($_SERVER['OS']) && (strpos(strtolower($_SERVER['OS']), 'windows')) > -1) {
            // if we're on windows we may to need to append .exe and '.' for the CLI
            $windowsExePath = '.\\'.$this->binPath . '.exe';
            if(file_exists($windowsExePath)) {
                $process = new Process(array_merge([$windowsExePath], $this->options, [$this->pdf, '-']));
            }
        }
        else {
            $process = new Process(array_merge([$this->binPath], $this->options, [$this->pdf, '-']));
        }
        
        $process->run();
        if(!$process->isSuccessful()) {
            throw new CouldNotExtractText($process);
        }
        
        return trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
    }
    
    public static function getText(string $pdf, string $binPath = null, array $options = []): string {
        return (new static($binPath))
            ->setOptions($options)
            ->setPdf($pdf)
            ->text();
    }
}
