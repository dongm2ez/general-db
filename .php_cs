<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->exclude('bootstrap/cache')
    ->exclude('storage')
    ->exclude('vendor')
    ->exclude('app/Helpers/Tools')
    ->exclude('tools')
    ->in(__DIR__)
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_superfluous_elseif' => true,
        'no_unneeded_curly_braces' => true,
        'phpdoc_order' => true,
        'phpdoc_types_order' => true,
        'align_multiline_comment' => true,
        'list_syntax' => [
            'syntax' => 'long', // list 使用 long 语法
        ],
        'ordered_class_elements' => true,
        'php_unit_strict' => true,
        'no_extra_consecutive_blank_lines' => true, //多余空白行
        'no_blank_lines_after_class_opening' => true, //类开始标签后不应该有空白行；
        'whitespace_after_comma_in_array' => true,
        'blank_line_before_return' => true,
        'function_typehint_space' => true, //函数参数逗号空格
        'method_separation' => true, // 方法后空行,
        'class_attributes_separation' => true, //类，方法必须用一个空行分隔。
        'array_indentation' => true,
        'function_declaration' => true,
        'method_argument_space' => [
            'ensure_fully_multiline' => true,
        ],
        'lowercase_constants' => true,
        'lowercase_keywords' => true,
        'line_ending' => true
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
