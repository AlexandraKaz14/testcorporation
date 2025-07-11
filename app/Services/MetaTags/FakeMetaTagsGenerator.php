<?php

declare(strict_types=1);

namespace App\Services\MetaTags;

use App\Services\MetaTags\Contracts\MetaTagsGeneratorInterface;

class FakeMetaTagsGenerator implements MetaTagsGeneratorInterface
{
    public function generate(string $description): array
    {
        $metaDescription = mb_substr($description, 0, 50, 'UTF-8') . '-' . 'краткое описание';

        return [
            'keywords' => 'мета-теги, тестирование, фейки-теги',
            'description' => $metaDescription,
        ];
    }
}
