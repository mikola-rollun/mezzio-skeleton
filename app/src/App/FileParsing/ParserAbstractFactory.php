<?php

declare(strict_types=1);

namespace App\FileParsing;

use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;
use App\FileParsing\Parsers\ParserInterface;
use App\Handler\ParsingHandler;

class ParserAbstractFactory implements AbstractFactoryInterface
{
    public const PARSER_KEY = 'EXECUTE';

    private const CONFIG_KEY = 'FileParserAbstractFactoryParseable';

    private const DEFAULT_INTERFACE = ParserInterface::class;

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config');

        //those ifs could be merged

        if (!isset($config[self::CONFIG_KEY])) {
            return false;
        }

        $servicesConfig = $config[self::CONFIG_KEY];

        if (!is_array($servicesConfig) || !array_key_exists($requestedName, $servicesConfig)) {
            return false;
        }

        if (!isset($servicesConfig[$requestedName][self::PARSER_KEY])) {
            return false;
        }

        if (!$container->has($servicesConfig[$requestedName][self::PARSER_KEY])) {
            return false;
        }

        $parser = $container->get($servicesConfig[$requestedName][self::PARSER_KEY]);

        return is_a($parser, self::DEFAULT_INTERFACE);
    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');

        $serviceConfig = $config[self::CONFIG_KEY][$requestedName][self::PARSER_KEY];

        $parser = $container->get($serviceConfig);

        return new ParsingHandler($parser);
    }
}