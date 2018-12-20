<?php

require_once __DIR__ . '/vendor/autoload.php';

\exec('git diff --cached --name-only', $output, $exitCode);

if ($exitCode !== 0) {
    exit($exitCode);
}

$output = \array_filter($output, function ($item) {
    return \substr($item, -4) === '.php';
});
$output = \array_map(function ($item) {
    return new \SplFileInfo($item);
}, $output);

$config = PhpCsFixer\Config::create();
$config->setFinder($output);
return $config;
