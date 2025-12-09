<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YoutubeController extends Controller
{
    public function index(Request $request)
    {
        $apiKey = config('services.youtube.api_key');

        // Read search query
        $query = $request->input('q', 'Laravel tutorial');

        // For pagination token
        $pageToken = $request->input('pageToken');

        // Call YouTube API
        $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'part' => 'snippet',
            'q' => $query,
            'type' => 'video',
            'maxResults' => 5,
            'key' => $apiKey,
            'pageToken' => $pageToken,
        ]);

        $data = $response->json();

        return view('youtube', [
            'videos' => $data['items'] ?? [],
            'nextPageToken' => $data['nextPageToken'] ?? null,
            'prevPageToken' => $data['prevPageToken'] ?? null,
            'query' => $query,
        ]);
    }
}
