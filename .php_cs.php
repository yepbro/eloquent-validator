<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS2.0' => true,
        'new_with_parentheses' => [
            'anonymous_class' => false,
            'named_class' => false,
        ],
        'trailing_comma_in_multiline' => [
            'elements' => ['arguments', 'array_destructuring', 'arrays', 'match', 'parameters'],
        ],
    ])
    ->setFinder($finder);