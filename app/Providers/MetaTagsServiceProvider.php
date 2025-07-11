<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\MetaTags\Contracts\MetaTagsGeneratorInterface;
use App\Services\MetaTags\FakeMetaTagsGenerator;
use App\Services\MetaTags\MetaTagsGeneratorService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class MetaTagsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MetaTagsGeneratorInterface::class, function ($app) {
            $driver = config('meta-tags.driver');

            return match ($driver) {
                'cloudflare' => new MetaTagsGeneratorService(new Client()),
                'testing' => new FakeMetaTagsGenerator(),
                default => throw new \Exception('Неверный драйвер для генерации мета-тегов.'),
            };
        });
    }

    public function boot()
    {
        //
    }
}
