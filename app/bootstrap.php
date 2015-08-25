<?php

    use Tracy\Debugger;

    require __DIR__ . '/../vendor/autoload.php';

    $configurator = new Nette\Configurator;

    Debugger::enable(isset($_ENV['NETTE_ENV']) ? $_ENV['NETTE_ENV'] : "prod");

    $configurator->enableDebugger(__DIR__ . '/../log');
    $configurator->setTempDirectory(__DIR__ . '/../temp');
    $configurator->createRobotLoader()
        ->addDirectory(__DIR__)
        ->addDirectory(__DIR__ . "/../vendor/less")
        ->addDirectory(__DIR__ . "/../vendor/me")
        ->register();

    $configurator->addConfig(__DIR__ . '/config/config.neon');
    $configurator->addConfig(__DIR__ . '/config/config.local.neon');

    $container = $configurator->createContainer();

    return $container;