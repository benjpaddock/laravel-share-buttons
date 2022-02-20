<?php

namespace Kudashevs\ShareButtons\ValueObjects;

class ProcessedCall
{
    /**
     * @var string
     */
    private $provider;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string $provider
     * @param string $url
     * @param array $options
     */
    public function __construct(string $provider, string $url, array $options)
    {
        $this->provider = $this->initProvider($provider);
        $this->url = $this->initUrl($url);
        $this->options = $this->initOptions($options);
    }

    /**
     * @param string $provider
     * @return string
     */
    private function initProvider(string $provider): string
    {
        if (trim($provider) === '') {
            throw new \InvalidArgumentException('A share provider argument cannot be empty.');
        }

        return $provider;
    }

    /**
     * @param string $url
     * @return string
     */
    private function initUrl(string $url): string
    {
        if (trim($url) === '') {
            throw new \InvalidArgumentException('A url argument cannot be empty.');
        }

        return $url;
    }

    /**
     * @param array $options
     * @return array
     */
    private function initOptions(array $options): array
    {
        return $options;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
