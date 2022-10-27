<?php

declare(strict_types=1);

namespace App\FileParsing\Parsers;

class ParseXML implements ParserInterface {
    public function parse(string $string): array {
        return ['todo' => $string];
    }
}
