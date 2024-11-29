<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(['app', 'tests']);

$config = new Config();
$config->setRules([
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
]);

$config->setFinder($finder);

return $config;
