<?php

declare(strict_types=1);

namespace App\FileParsing\Parsers;

class ParseYML implements ParserInterface {
    public function parse(string $string): array {
        return ['todo' => $string];
    }
}
