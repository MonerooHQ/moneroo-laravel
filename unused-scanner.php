<?php

$projectPath = __DIR__;
//Declare directories which contains php code
$scanDirectories = [
    $projectPath.'/config/',
    $projectPath.'/src/',
    $projectPath.'/tests/',
];
//Optionally declare standalone files
$scanFiles = [
];

return [
    'composerJsonPath' => $projectPath.'/composer.json',
    'vendorPath' => $projectPath.'/vendor/',

    'skipPackages' => [],

    'scanDirectories' => $scanDirectories,
    'scanFiles' => $scanFiles,
];
