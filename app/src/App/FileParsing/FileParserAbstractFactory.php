<?php

declare(strict_types=1);

namespace App\FileParsing;

use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;
use App\FileParsing\Parsers\ParserInterface;
use App\Handler\ParsingHandler;

class ParserAbstractFactory implements AbstractFactoryInterface
{
    private const CONFIG_KEY = 'FileParserAbstractFactoryParseable';

    private const DEFAULT_INTERFACE = ParserInterface::class;

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config');


        if (!isset($config[self::CONFIG_KEY])) {
            return false;
        }

        $servicesConfig = $config[self::CONFIG_KEY];

        if (!is_array($servicesConfig) || !array_key_exists($requestedName, $servicesConfig)) {
            return false;
        }

        return 
            isset($servicesConfig[$requestedName]) 
            && is_a($servicesConfig[$requestedName], self::DEFAULT_INTERFACE, true);
    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');

        $serviceConfig = $config[self::CONFIG_KEY][$requestedName];

        $parser = $container->get($serviceConfig);

        return new ParsingHandler($parser);
    }
}