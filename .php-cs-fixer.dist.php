<?php declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'public'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'linebreak_after_opening_tag' => false,
        'blank_line_after_opening_tag' => false,
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
;
