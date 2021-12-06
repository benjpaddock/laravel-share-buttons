<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Twitter implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $providersUrl = config('laravel-share.providers.twitter.url');

        $title = empty($options['title']) ? config('laravel-share.providers.twitter.text') : $options['title'];

        return $providersUrl . '?text=' . urlencode($title) . '&url=' . $url;
    }
}
