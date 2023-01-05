<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\Table\CommentsTable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class ListHandler implements RequestHandlerInterface, MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    
    /**
     * @var \App\Model\Table\CommentsTable
     */
    private $commentsTable;
    
    public function __construct(TemplateRendererInterface $renderer, CommentsTable $commentsTable )
    {
        $this->renderer = $renderer;
        $this->commentsTable = $commentsTable;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::list',
            [] // parameters to pass to template
        ));
    }
    
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.
        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::list',
            [
                'avis' => $this->commentsTable->fetchAll()
            ] // parameters to pass to template
        ));  }
}
