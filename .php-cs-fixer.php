<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR12'                       => true,
    'array_indentation'            => true,
    'array_syntax'                 => ['syntax' => 'short'],
    'combine_consecutive_unsets'   => true,
    'class_attributes_separation'  => ['elements' => [
        'method'       => 'one',
        'property'     => 'one',
        'const'        => 'one',
        'trait_import' => 'one',
    ],
    ],
    'multiline_whitespace_before_semicolons' => false,
    'single_quote'                           => true,
    'binary_operator_spaces'                 => [
        'operators' => [
            '=>' => 'align',
        ],
    ],
    'curly_braces_position'                   => true,
    'blank_line_after_opening_tag'            => true,
    'single_space_around_construct'           => true,
    'control_structure_braces'                => true,
    'control_structure_continuation_position' => true,
    'declare_parentheses'                     => true,
    'statement_indentation'                   => true,
    'no_multiple_statements_per_line'         => true,
    'concat_space'                            => ['spacing' => 'one'],
    'declare_equal_normalize'                 => true,
    'type_declaration_spaces'                 => true,
    'include'                                 => true,
    'lowercase_cast'                          => true,
    'no_blank_lines_after_class_opening'      => true,
    'no_blank_lines_after_phpdoc'             => true,
    'no_empty_comment'                        => true,
    'no_empty_phpdoc'                         => true,
    'no_empty_statement'                      => true,
    'not_operator_with_successor_space'       => true,
    'no_extra_blank_lines'                    => [
        'tokens' => [
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'square_brace_block',
            'throw',
            'use',
            'break',
            'continue',
            'return',
            'throw',
        ],
    ],
    'no_leading_import_slash'                     => true,
    'no_leading_namespace_whitespace'             => true,
    'no_mixed_echo_print'                         => ['use' => 'echo'],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_short_bool_cast'                          => true,
    'no_singleline_whitespace_before_semicolons'  => true,
    'no_spaces_around_offset'                     => true,
    'no_trailing_comma_in_singleline'             => true,
    'no_unneeded_control_parentheses'             => true,
    'no_unused_imports'                           => true,
    'no_whitespace_before_comma_in_array'         => true,
    'no_whitespace_in_blank_line'                 => true,
    'object_operator_without_whitespace'          => true,
    'phpdoc_align'                                => true,
    'phpdoc_annotation_without_dot'               => true,
    'phpdoc_indent'                               => true,
    'phpdoc_no_alias_tag'                         => true,
    'phpdoc_scalar'                               => true,
    'phpdoc_separation'                           => true,
    'phpdoc_single_line_var_spacing'              => true,
    'phpdoc_to_comment'                           => true,
    'phpdoc_trim'                                 => true,
    'phpdoc_types'                                => true,
    'return_type_declaration'                     => true,
    'short_scalar_cast'                           => true,
    'single_class_element_per_statement'          => true,
    'space_after_semicolon'                       => true,
    'standardize_not_equals'                      => true,
    'ternary_operator_spaces'                     => true,
    'trim_array_spaces'                           => true,
    'unary_operator_spaces'                       => true,
    'whitespace_after_comma_in_array'             => true,
    'trailing_comma_in_multiline'                 => true,
    'simplified_if_return'                        => true,
    'no_superfluous_phpdoc_tags'                  => true,
    'no_useless_else'                             => true,
    'ordered_imports'                             => true,
    'phpdoc_order'                                => true,
    'phpdoc_summary'                              => true,
    'single_line_comment_style'                   => true,
    'single_trait_insert_per_statement'           => true,
];

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/config',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new Config();
return $config->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
