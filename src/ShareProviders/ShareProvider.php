<?php

namespace Kudashevs\ShareButtons\ShareProviders;

abstract class ShareProvider
{
    /**
     * @param string $url
     * @param string $title
     * @param array $options
     * @return string
     */
    abstract public function buildUrl(string $url, string $title, array $options): string;

    /**
     * @param string $provider
     * @param string $title
     * @return string
     */
    final protected function prepareTitle(string $title): string
    {
        $provider = $this->getProviderName();
        $key = 'share-buttons.providers.' . $provider . '.text';

        if (empty($title) && config()->has($key)) {
            return urlencode(config($key));
        }

        return urlencode($title);
    }

    /**
     * @return string
     */
    private function getProviderName(): string
    {
        $parsed = explode('\\', get_class($this));

        return mb_strtolower(end($parsed));
    }
}
