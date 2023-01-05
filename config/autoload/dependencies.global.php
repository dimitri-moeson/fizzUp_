<?php

declare(strict_types=1);
    
    define('DB_USER',"root");
    define('DB_PASS',"");
    define('DB_NAME',"fizzup");
    define('DB_HOST',"127.0.0.1");


return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
			Laminas\Db\Adapter\Adapter::class => Laminas\Db\Adapter\AdapterInterface::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
			Laminas\Db\Adapter\AdapterInterface::class => Laminas\Db\Adapter\AdapterServiceFactory::class,
        ],
    ],
	
	'db' => [
	
		'driver' => 'Pdo',
		'dsn' => 'mysql:dbname='.DB_NAME.';hostname='.DB_HOST,
		'driver_options' => [
			PDO::MYSQL_ATTR_INIT_COMMAND => ' SET NAMES \'UTF8\' '
		]
		
	],
];
