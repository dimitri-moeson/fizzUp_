<?php

declare(strict_types=1);

namespace App\Handler;

use App\Model\Table\CommentsTable;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class ListHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ListHandler
    {
        return new ListHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(CommentsTable::class)

        );
    }
}
