<?php

declare(strict_types=1);

namespace App\Handler;

use App\Form\CommentForm;
use App\Model\Table\CommentsTable;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class CommentHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CommentHandler
    {
        return new CommentHandler(
            $container->get("FormElementManager")->get(CommentForm::class),
            $container->get(TemplateRendererInterface::class),
            $container->get(CommentsTable::class)
        );
    }
}
