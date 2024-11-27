<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        'app',
        'routes',
        'database',
        'tests',
        'resources',
    ]);

return PhpCsFixer\Config::create()
    ->setFinder($finder)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
    ]);
