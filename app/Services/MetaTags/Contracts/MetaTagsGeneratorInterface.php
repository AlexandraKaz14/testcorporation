<?php

declare(strict_types=1);

namespace App\Services\MetaTags\Contracts;

interface MetaTagsGeneratorInterface
{
    public function generate(string $description): array;
}
