<?php

declare(strict_types=1);

namespace App;

use App\Model\Table\CommentsTable;
use App\Model\Table\CommentsTableFactory;
use App\View\Helper\FlashHelper;

/**
 * The configuration provider for the App module
 * --
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'view_helpers' => [
                'invokables' => [
                    "flashMessenger" => FlashHelper::class
                ]
            ]
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                //Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                //Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                CommentsTable::class => CommentsTableFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
