<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\YoutubeService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $youtube;

    public function __construct(YoutubeService $youtube)
    {
        $this->youtube = $youtube;
    }

    public function youtube(Request $request)
    {
        $data = $request->validate([
            'q' => 'required|string|min:1',
            'pageToken' => 'nullable|string',
        ]);

        $result = $this->youtube->search($data['q'], $data['pageToken'] ?? null, 5);

        if (isset($result['error']) && $result['error']) {
            return response()->json(['message' => 'External API error', 'detail' => $result], 502);
        }

        // Optionally map response to minimal structure:
        $items = $result['items'] ?? [];

        $mapped = array_map(function ($v) {
            return [
                'videoId' => $v['id']['videoId'] ?? null,
                'title' => $v['snippet']['title'] ?? '',
                'description' => $v['snippet']['description'] ?? '',
                'thumbnail' => $v['snippet']['thumbnails']['medium']['url'] ?? null,
            ];
        }, $items);

        return response()->json([
            'items' => $mapped,
            'nextPageToken' => $result['nextPageToken'] ?? null,
            'prevPageToken' => $result['prevPageToken'] ?? null,
        ]);
    }
}
