<?php

const DIR = '/app/src'; // Sources root

$finder = PhpCsFixer\Finder::create()
    ->in(DIR)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12:risky' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
])
    ->setFinder($finder)
    ;
