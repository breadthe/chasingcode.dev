<?php

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'omigosh Labs',
    'siteDescription' => 'omigosh Labs - Software that doesn\'t go boom!',
    'siteAuthor' => 'The Dev',

    // collections
    'collections' => [
        'posts' => [
            'author' => 'The Dev', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => function ($page)
            {
                $slug = preg_replace('/[0-9]{4}-[0-9]{2}-[0-9]{2}-/i', '', $page->getFilename());
                return "blog/$slug";
            },
        ],
        'categories' => [
            'path' => '/blog/categories/{filename}',
            'posts' => function ($page, $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->categories ? in_array($page->getFilename(), $post->categories, true) : false;
                });
            },
        ],
    ],

    // helpers
    'getDate' => function ($page) {
        return Datetime::createFromFormat('U', $page->date);
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
        return ends_with(trimPath($page->getPath()), trimPath($path));
    },

    /**
     * Determines if a page belongs to a path
     * Example: /blog belongs to /blog; so does /blog/my-first-post/
     */
    'belongsTo' => function ($page, $path) {
        return starts_with(trimPath($page->getPath()), trimPath($path));
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
            $str .=  "Photo by ";

            if ($html) {
                if ($image_author_url) {
                    $str .= '<a href="' . $image_author_url . '" title="' . $image_author . '">' . $image_author . '</a>';
                } else {
                    $str .=  "$image_author ($image_author_url)";
                }
            } else {
                $str .= "$image_author";
            }
        }

        if ($page->image_unsplash) {
            if ($html) {
                $str .= ' on <a href="https://unsplash.com" title="Unsplashs">Unsplash</a>';
            } else {
                $str .= ' on Unsplash (https://unsplash.com)';
            }
        }

        return $str;
    },
];
