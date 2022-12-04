<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateShareButtonsUrlPresenter
{
    protected Templater $templater;

    protected string $name;

    public function __construct(array $options = [])
    {
        $this->initTemplater($options);
    }

    /**
     * @throws InvalidTemplaterFactoryArgument
     */
    private function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    /**
     * Return a share provider's ready-to-use URL.
     *
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function generateUrl(string $name, array $arguments): string
    {
        $this->initElementName($name);

        $template = $this->retrieveUrlTemplate();
        $replacements = $this->retrieveUrlReplacements($arguments);

        $encoded = $this->encodeReplacements($replacements);

        return $this->templater->process($template, $encoded);
    }

    protected function initElementName(string $name): void
    {
        $this->name = $name;
    }

    protected function retrieveUrlTemplate(): string
    {
        $url = config('share-buttons.buttons.' . $this->name . '.url', '');

        return $this->isHashedUrl()
            ? '#'
            : $url;
    }

    protected function isHashedUrl(): bool
    {
        return config()->has('share-buttons.buttons.' . $this->name . '.extra.hash') &&
            config('share-buttons.buttons.' . $this->name . '.extra.hash') === true;
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveUrlReplacements(array $arguments): array
    {
        $elementReplacements = $this->retrieveElementReplacements();
        $applicableArguments = array_filter($arguments, 'strlen');

        return array_merge($elementReplacements, $applicableArguments);
    }

    protected function retrieveElementReplacements(): array
    {
        return array_merge([
            'text' => $this->retrieveText(),
        ], $this->retrieveExtras());
    }

    protected function retrieveText(): string
    {
        return config('share-buttons.buttons.' . $this->name . '.text', '');
    }

    protected function retrieveExtras(): array
    {
        return config('share-buttons.buttons.' . $this->name . '.extra', []);
    }

    protected function encodeReplacements(array $replacements): array
    {
        return array_map(function (string $value) {
            return urlencode($value);
        }, $replacements);
    }
}
