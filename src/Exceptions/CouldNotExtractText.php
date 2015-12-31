<?php

namespace Spatie\PdfToText\Exceptions;

use Symfony\Component\Process\Exception\ProcessFailedException;

class CouldNotExtractText extends ProcessFailedException
{
}
