<?php

declare(strict_types=1);

use AxaZara\CS\Finder;
use AxaZara\CS\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

// Routes for analysis with `php-cs-fixer`
$routes = [
    './src',
    './config',
    './tests'
];

return Config::createWithFinder(
    finder: Finder::createWithRoutes($routes),
    overwrittenRules: [
        '@PHP8x3Migration'              => true,
    ]
)->setParallelConfig(ParallelConfigFactory::detect());
