<svg class="no-image bd-placeholder-img align-self-center mr-3" width="{{ $width }}" height="{{ $height }}" style="min-width: {{ $width }}px;" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: {{ $content->title }}" preserveAspectRatio="xMidYMid slice" role="img">
    <title>{{ $content->title }}</title>
    <rect width="100%" height="100%" fill="{{ $background ?? config('blog.no-image.background') }}"/>
    <text x="50%" y="50%" dy=".3em" fill="{{ $color ?? config('blog.no-image.color') }}">{{ strtoupper($content->title[0]) }}</text>
</svg>
