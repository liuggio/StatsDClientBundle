<?php
// see https://github.com/FriendsOfPHP/PHP-CS-Fixer

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/Command', __DIR__.'/DependencyInjection', __DIR__.'/Listener', __DIR__.'/Service', __DIR__.'/StatsCollector', __DIR__.'/Tests'])
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'declare_strict_types' => false,
        'native_function_invocation' => true,
    ])
    ->setFinder($finder)
;
