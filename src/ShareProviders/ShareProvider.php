<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\ShareProviders;

use Kudashevs\ShareButtons\Exceptions\InvalidProviderException;
use Kudashevs\ShareButtons\Factories\ShareProviderFactory;
use Kudashevs\ShareButtons\Templaters\LaravelTemplater;
use Kudashevs\ShareButtons\Templaters\Templater;

abstract class ShareProvider
{
    protected Templater $templater;

    protected string $name;

    protected string $url = '#';

    protected array $options = [];

    final public function __construct()
    {
        $this->checkInternals();

        $this->initTemplater();
    }

    /**
     * @return ShareProvider
     */
    public static function create(): ShareProvider
    {
        return new static();
    }

    /**
     * @throws InvalidProviderException
     */
    protected function checkInternals(): void
    {
        if (!$this->isValidProvider()) {
            throw new InvalidProviderException(
                sprintf('The %s is not a valid name for the %s.', $this->name, static::class)
            );
        }
    }

    protected function isValidProvider(): bool
    {
        /**
         * Even though this check may seem too thorough or even exceeding, there is a reason for this.
         * Because a lot of configurations and styles depend on the internal name of a share provider,
         * we want to be sure that the internal name corresponds to the exact share provider class.
         */
        return ShareProviderFactory::isValidProvider($this->name, static::class);
    }

    protected function initTemplater(): void
    {
        $this->templater = $this->createTemplater();
    }

    protected function createTemplater(): Templater
    {
        return new LaravelTemplater();
    }

    /**
     * Return a share provider name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return a share provider URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Return provided options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $link
     * @param string $title
     * @param array $options
     * @return string
     */
    abstract public function buildUrl(string $link, string $title, array $options): string;

    final protected function retrieveProviderUrl(): string
    {
        return config('share-buttons.providers.' . $this->name . '.url', '');
    }

    /**
     * Gather and prepare all of the settings.
     *
     * @param string $link
     * @param string $title
     * @param array $options
     * @return array
     */
    final protected function retrieveReplacements(string $link, string $title, array $options = []): array
    {
        $initialReplacements = [
            'url' => $link,
            'title' => $this->prepareTitle($title),
        ];

        $extraReplacements = $this->prepareExtras($options);

        return array_merge($extraReplacements, $initialReplacements);
    }

    protected function prepareTitle(string $title): string
    {
        $text = config('share-buttons.providers.' . $this->name . '.text', '');

        $result = ($this->isEmptyTitle($title))
            ? $text
            : $title;

        return urlencode($result);
    }

    protected function isEmptyTitle(string $title): bool
    {
        return trim($title) === '';
    }

    protected function prepareExtras(array $options): array
    {
        $extra = config('share-buttons.providers.' . $this->name . '.extra', []);

        return array_map(static function (string $value) {
            return urlencode($value);
        }, array_merge($extra, $options));
    }
}
