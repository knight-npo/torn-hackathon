<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'curly_braces_position' => [
            'classes_opening_brace' => 'same_line',
            'functions_opening_brace' => 'same_line'
        ],
    ])
    ->setFinder($finder)
;
