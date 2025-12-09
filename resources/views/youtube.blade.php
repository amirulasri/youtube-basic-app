<!DOCTYPE html>
<html>

<head>
    <title>YouTube Search</title>
</head>

<body>

    <h1>YouTube Video Search</h1>

    <!-- Search Bar -->
    <form action="{{ route('youtube.search') }}" method="GET">
        <input type="text" name="q" value="{{ $query }}" placeholder="Search videos..." required>
        <button type="submit">Search</button>
    </form>

    <hr>

    <!-- Video Results -->
    @foreach ($videos as $video)
    <div style="margin-bottom:20px">
        <h3>{{ $video['snippet']['title'] }}</h3>

        <img src="{{ $video['snippet']['thumbnails']['medium']['url'] }}" alt="">
        <br>

        <a href="https://www.youtube.com/watch?v={{ $video['id']['videoId'] }}" target="_blank">
            Watch Video
        </a>
    </div>
    <hr>
    @endforeach

    <!-- Pagination -->
    <div style="margin-top:20px;">
        @if ($prevPageToken)
        <a href="{{ route('youtube.search', ['q' => $query, 'pageToken' => $prevPageToken]) }}">Prev</a>
        @endif

        @if ($nextPageToken)
        <a href="{{ route('youtube.search', ['q' => $query, 'pageToken' => $nextPageToken]) }}" style="margin-left:10px;">
            Next
        </a>
        @endif
    </div>

</body>

</html>