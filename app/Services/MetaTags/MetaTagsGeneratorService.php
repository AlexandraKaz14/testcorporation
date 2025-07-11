<?php

declare(strict_types=1);

namespace App\Services\MetaTags;

use App\Services\MetaTags\Contracts\MetaTagsGeneratorInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MetaTagsGeneratorService implements MetaTagsGeneratorInterface
{
    protected Client $client;

    protected string $apiUrl;

    protected string $authToken;

    public function __construct()
    {
        $this->client = new Client();
        $accountId = config('services.cloudflare-api.account_id');
        $this->apiUrl = "https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/@cf/deepseek-ai/deepseek-r1-distill-qwen-32b";
        $this->authToken = config('services.cloudflare-api.token');
    }

    public function generate(string $description): array
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->authToken}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Ты — помощник для генерации мета-тегов и мета-описаний для страниц с тестами. Твоя задача — создать ключевые слова и краткое описание на основе предоставленного описания теста.
            - Ключевые слова: должны быть разделены запятыми, не содержать слово "тест", и быть релевантными описанию.
            - Краткое описание: должно состоять из 1-2 предложений, быть грамотно написанным на русском языке и отражать суть теста.
            - Ответ должен быть строго в формате JSON, содержать ровно один объект с полями "description" и "keywords".
            - Не добавляй никаких дополнительных символов, текста или разметки. Только валидный JSON.',
                        ],
                        [
                            'role' => 'user',
                            'content' => "Описание теста: '{$description}'",
                        ],
                    ],
                    'max_tokens' => 500,
                ],
            ]);

            $responseContent = $response->getBody()
                ->getContents();
            $data = json_decode($responseContent, true);

            if (!isset($data['result']['response'])) {
                throw new \Exception('Ответ от API не содержит данных.');
            }

            $responseString = $data['result']['response'];

            $responseString = str_replace(["\n", "\r", '</think>'], '', $responseString);
            $responseString = trim($responseString);

            preg_match_all('/\{.*?\}/s', $responseString, $matches);

            if (empty($matches[0])) {
                throw new \Exception('Не удалось найти JSON-объект в ответе.');
            }

            $cleanJson = $matches[0][0];

            $parsedResponse = json_decode($cleanJson, true);

            if ($parsedResponse === null) {
                throw new \Exception('Ошибка декодирования JSON: ' . json_last_error_msg());
            }

            if (!isset($parsedResponse['description']) || !isset($parsedResponse['keywords'])) {
                throw new \Exception('JSON-объект не содержит обязательных полей "description" и "keywords".');
            }

            return [
                'keywords' => $parsedResponse['keywords'],
                'description' => $parsedResponse['description'],
            ];

        } catch (\Exception $e) {
            Log::error('Ошибка в MetaTagsGeneratorService: ' . $e->getMessage());

            return [
                'keywords' => '',
                'description' => '',
            ];
        }
    }
}
