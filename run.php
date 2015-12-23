<?php
/**
 * Created by Érick Carvalho on 17/12/2015.
 */

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use WordFilter\Console\Commands\MainMenuCommand;
use WordFilter\Console\Commands\CorrectorCommand;
use WordFilter\Console\Commands\DictionaryManagerCommand;

$application = new Application('Word Filter', '1.0.1');
$application->add(new DictionaryManagerCommand());
$application->add(new CorrectorCommand());
$application->add(new MainMenuCommand());
$application->setDefaultCommand('menu');
$application->run();