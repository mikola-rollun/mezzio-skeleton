<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\FileParsing\Parsers\ParserInterface;

class ParsingHandler implements RequestHandlerInterface
{
    /** @var ParserInterface */
    private $parser;

    public function __construct(
        ParserInterface $parser,
    ) {
        $this->parser = $parser;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $result = $this->parser->parse("<div><span>Hello world</span></div>");
        
        return new JsonResponse($result);
    }
}
