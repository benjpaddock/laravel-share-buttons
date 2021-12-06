<?php

namespace Kudashevs\ShareButtons\ShareProviders\Providers;

class Reddit implements ShareProvider
{

    public function buildUrl(string $url, array $options = []): string
    {
        $title = empty($options['title']) ? config('share-buttons.providers.reddit.text') : $options['title'];

        $providersUrl = config('share-buttons.providers.reddit.url');

        return $providersUrl . '?title=' . urlencode($title) . '&url=' . $url;
    }
}
