<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Test;
use App\Services\MetaTags\Contracts\MetaTagsGeneratorInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MetaTagsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $test;

    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    public function handle(MetaTagsGeneratorInterface $metaTagsGenerator): void
    {
        try {
            $description = $this->test->description;

            $metaTags = $metaTagsGenerator->generate($description);
            $metaKeywords = $metaTags['keywords'] ?? '';
            $metaDescription = $metaTags['description'] ?? '';

            $this->test->update([
                'meta_keywords' => $metaKeywords,
                'meta_description' => $metaDescription,
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка в MetaTagsJob: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }

    }
}
