<?php

const SRC = __DIR__ . '/src';

$finder = PhpCsFixer\Finder::create()
    ->in(SRC)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12:risky' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
])
    ->setFinder($finder)
    ;
