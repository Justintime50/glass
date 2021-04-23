<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ {{ config('app.name') }} ]]></title>
        <link><![CDATA[ {{ config('app.url') }} ]]></link>
        <description><![CDATA[ Minimalist blog featuring syntax highlighting, images, comments, themes, and SEO out of the box. ]]></description>
        <language>en</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <link>{{ $post->slug }}</link>
                <description><![CDATA[{!! $post->post !!}]]></description>
                <category>@if (isset($post->category->category)) {{ $post->category->category }} @else {{ 'Uncategorized' }} @endif</category>
                <author><![CDATA[{{ $post->user->name  }}]]></author>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
