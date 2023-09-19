<?php

declare(strict_types=1);

use AxaZara\CS\Finder;
use AxaZara\CS\Config;

// Routes for analysis with `php-cs-fixer`
$routes = ['./src', './config', './tests'];

return Config::createWithFinder(Finder::createWithRoutes($routes));
