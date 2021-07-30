#! /usr/bin/env php
<?php 
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

define('BASE_DIR', __DIR__);

if (is_file(BASE_DIR.'/vendor/autoload.php')) {
    require BASE_DIR.'/vendor/autoload.php'; # for local testing
} else {
    require BASE_DIR.'/../../autoload.php'; # for production
}

$app = new Application('Agência Escape Installer', '0.2.2');
$app->add(new Escape\Console\AppInstallCommand);
$app->add(new Escape\Console\ManagerInstallCommand);
$app->add(new Escape\Console\CloneCommand);
$app->add(new Escape\Console\OptimizeImagesCommand);
$app->run();