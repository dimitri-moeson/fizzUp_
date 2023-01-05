<?php
    declare(strict_types=1);
    
    namespace App\Model\Table;
    
    use Laminas\Db\Adapter\Adapter;
    use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
    use Laminas\ServiceManager\Exception\ServiceNotFoundException;
    use Laminas\ServiceManager\Factory\FactoryInterface;
    use Psr\Container\ContainerExceptionInterface;
    use Psr\Container\ContainerInterface;

    class CommentsTableFactory implements FactoryInterface
    {
    
        /**
         * Create an object
         *
         * @param  string $requestedName
         * @param  null|array<mixed>  $options
         *
         * @return object
         * @throws ServiceNotFoundException If unable to resolve the service.
         * @throws ServiceNotCreatedException If an exception is raised when creating a service.
         * @throws ContainerExceptionInterface If any other error occurs.
         */
        public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
        {
            // TODO: Implement __invoke() method.
            
            return new CommentsTable(
                $container->get(Adapter::class)
            );
        }
    }