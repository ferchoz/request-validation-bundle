<?php

$finder = PhpCsFixer\Finder::create()->in(['src', 'tests']);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        '@PHP81Migration' => true,
        '@PHP80Migration:risky' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'no_extra_blank_lines' => true,
        'ordered_class_elements' => true,
        'class_attributes_separation' => [
            'elements' => ['property' => 'none', 'const' => 'none', 'method' => 'one'],
        ],
        'phpdoc_align' => true,
    ])
    ->setCacheFile(__DIR__ . '/vendor/.php-cs-fixer.cache')
    ->setFinder($finder);
