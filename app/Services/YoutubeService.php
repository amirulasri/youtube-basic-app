<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class YoutubeService
{
    protected $apiKey;
    protected $base = 'https://www.googleapis.com/youtube/v3/';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    /**
     * Search videos (returns array)
     */
    public function search(string $q, ?string $pageToken = null, int $max = 5)
    {
        $params = [
            'part' => 'snippet',
            'q' => $q,
            'type' => 'video',
            'maxResults' => $max,
            'key' => $this->apiKey,
        ];

        if ($pageToken) $params['pageToken'] = $pageToken;

        $response = Http::retry(2, 100)->get($this->base . 'search', $params);

        if (! $response->successful()) {
            // Basic error propagation; you can create custom exceptions
            return [
                'error' => true,
                'status' => $response->status(),
                'body' => $response->body(),
            ];
        }

        return $response->json();
    }
}
