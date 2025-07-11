<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/lang',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
        __DIR__ . '/ecs.php',
    ])
    ->withSkip(skip: [
        __DIR__ . '/bootstrap/cache/*',
        NotOperatorWithSuccessorSpaceFixer::class,
        LineLengthFixer::class,

    ])
    ->withParallel()
    ->withSets(sets: [
        SetList::PSR_12,
        SetList::CLEAN_CODE,
        SetList::COMMON,
        SetList::SYMPLIFY,
        SetList::STRICT,
    ])

    // add a single rule
    ->withRules([
        NoUnusedImportsFixer::class,
    ])

    // add sets - group of rules
    ->withPreparedSets(
        arrays: true,
        namespaces: true,
        spaces: true,
        docblocks: true,
        comments: true,
    );
