<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
    <loc>{{ url('/') }}</loc>
    <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
    <priority>0.5</priority>
    <changefreq>daily</changefreq>
  </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ route('post.id', $post->id) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach

    @foreach ($pages as $page)
        <url>
            <loc>{{ route('page.id', $page->id) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
</urlset>