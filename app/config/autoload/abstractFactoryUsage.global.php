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
            'ParseXMLService' => ParseXML::class,
            'ParseJsonService' => ParseJson::class,
            'ParseYmlService' => ParseYml::class
        ],
        'factories' => [

        ],
        'abstract_factories' => [
            ParserAbstractFactory::class
        ],
    ],
    'FileParserAbstractFactoryParseable' => [
        'ParseXML' => [
            ParserAbstractFactory::PARSER_KEY => "ParseYmlService", 
        ],
        'ParseJSON' => [
            ParserAbstractFactory::PARSER_KEY => "ParseJsonService", 
        ],
        'ParseYML' => [
            ParserAbstractFactory::PARSER_KEY => "ParseYmlService"
        ]
    ]
];