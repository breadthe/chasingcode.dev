<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Chasing Code',
    'siteDescription' => 'Full stack dev in Chicago | PHP | Laravel | Livewire | Svelte | Tailwind | Tauri',
    'siteAuthor' => 'Constantin',
    'twitterHandle' => 'brbcoding',

    // collections
    'collections' => [
        'posts' => [
            'author' => 'Constantin', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => function ($page) {
                $slug = preg_replace('/[0-9]{4}-[0-9]{2}-[0-9]{2}-/i', '', $page->getFilename());
                return "blog/$slug";
            },
        ],
        'games' => [
            'author' => 'Constantin', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => function ($page) {
                $slug = preg_replace('/[0-9]{4}-[0-9]{2}-[0-9]{2}-/i', '', $page->getFilename());
                return "games/$slug";
            },
        ],
        'tags' => [
            'path' => '/blog/tags/{filename}',
            'sort' => '-title',
            'posts' => function ($page, Collection $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->tags ? in_array($page->getFilename(), $post->tags, true) : false;
                });
            },
        ],
    ],

    // helpers
    'getDate' => function ($page) {
        return Datetime::createFromFormat('U', $page->date);
    },
    'getUpdatedDate' => function ($page) {
        return $page->updated ? Datetime::createFromFormat('U', $page->updated) : null;
    },
    'getExcerpt' => function ($page, $length = 255) {
        $content = $page->excerpt ?? $page->getContent();
        $cleaned = strip_tags(
            preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content),
            '<code>'
        );

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },

    /**
     * Determines if a page belongs to a path
     * Example: /blog belongs to /blog; so does /blog/my-first-post/
     */
    'belongsTo' => function ($page, $path) {
        return Str::startsWith(trimPath($page->getPath()), trimPath($path));
    },

    /**
     * Builds the image attribution string for a post hero image based on additional post metadata
     * Example: Photo by Chris Ried (https://unsplash.com/@cdr6934) on Unsplash (https://unsplash.com)
     */
    'imageAttribution' => function ($page, $html = false) {
        $str = '';

        $image_author = $page->image_author;
        $image_author_url = $page->image_author_url;

        if ($image_author) {
            $str .= "Photo by ";

            if ($html) {
                if ($image_author_url) {
                    $str .= '<a href="' . $image_author_url . '" title="' . $image_author . '">' . $image_author . '</a>';
                } else {
                    $str .= "$image_author ($image_author_url)";
                }
            } else {
                $str .= "$image_author";
            }
        }

        if ($page->image_unsplash) {
            if ($html) {
                $str .= ' on <a href="https://unsplash.com" title="Unsplash">Unsplash</a>';
            } else {
                $str .= ' on Unsplash (https://unsplash.com)';
            }
        }

        return $str;
    },
];
