<?php

declare(strict_types=1);

use App\FileParsing\Parsers\ParseXML;
use App\FileParsing\Parsers\ParseJson;
use App\FileParsing\Parsers\ParseYml;
use App\FileParsing\ParserAbstractFactory;

return [
    'dependencies' => [
        'aliases' => [

        ],
        'invokables' => [
            // 'ParseXML' => ParseXML::class,
            // 'ParseJson' => ParseJson::class,
            // 'ParseYml' => ParseYml::class
        ],
        'factories' => [

        ],
        'abstract_factories' => [
            ParserAbstractFactory::class
        ],
    ],
    'FileParserAbstractFactoryParseable' => [
        'ParseXML' => ParseXML::class, 
        'ParseJSON' => ParseJson::class, 
        'ParseYML' => ParseYml::class
    ]
];