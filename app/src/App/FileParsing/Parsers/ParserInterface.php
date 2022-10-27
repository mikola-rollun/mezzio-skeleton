<?php

declare(strict_types=1);

namespace App\FileParsing\Parsers;

interface ParserInterface
{
    public function parse(string $string): array;
}
