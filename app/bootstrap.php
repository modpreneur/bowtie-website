<?php

    require __DIR__ . '/../vendor/autoload.php';

    $configurator = new Nette\Configurator;

    $_ENV['NETTE_ENV'] == "production" ? $configurator->setDebugMode(false) : $configurator->setDebugMode(true);

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