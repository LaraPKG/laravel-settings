<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('bootstrap/*')
    ->notPath('storage/*')
    ->notPath('resources/view/mail/*')
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline_array' => true,
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'blank_line_after_opening_tag' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_extra_blank_lines' => false,
        'no_leading_import_slash' => true,
        'no_trailing_whitespace' => true,
        'declare_equal_normalize' => ['space' => 'none'],
        'lowercase_cast' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_without_name' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => false,
        ],
        'new_with_braces' => true,
        'braces' => [
            'allow_single_line_closure' => true,
            'position_after_functions_and_oop_constructs' => 'next',
            'position_after_control_structures' => 'same',
            'position_after_anonymous_constructs' => 'same',
        ],
        'ordered_class_elements' => [
            'order' => ['use_trait'],
        ],
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sortAlgorithm' => 'alpha',
        ],
        'short_scalar_cast' => true,
        'single_import_per_statement' => false,
        'ternary_operator_spaces' => true,
        'visibility_required' => [
            'elements' => ['const', 'method', 'property'],
        ],
    ])
    ->setFinder($finder);
