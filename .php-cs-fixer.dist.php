<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/src')
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@Symfony' => true,

        /*
         * Personal opinion.
         */
        'yoda_style' => false,
        'phpdoc_align' => ['align' => 'left'],
        'php_unit_method_casing' => ['case' => 'snake_case'],

    ])
    ->setFinder($finder)
;
