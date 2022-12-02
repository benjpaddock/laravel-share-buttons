<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Presenters;

use Kudashevs\ShareButtons\Exceptions\InvalidTemplaterFactoryArgument;
use Kudashevs\ShareButtons\Factories\TemplaterFactory;
use Kudashevs\ShareButtons\Presenters\Formatters\AttributesFormatter;
use Kudashevs\ShareButtons\Presenters\Formatters\SimpleAttributesFormatter;
use Kudashevs\ShareButtons\Templaters\Templater;

class TemplateShareButtonsPresenter implements ShareButtonsPresenter
{
    protected Templater $templater;

    protected TemplateUrlPresenter $presenter;

    protected AttributesFormatter $formatter;

    /**
     * Contain options related to the representation of share buttons.
     *
     * @var array{'block_prefix': string, 'block_suffix': string, 'element_prefix': string, 'element_suffix': string}
     */
    protected array $styling = [
        'block_prefix' => '',
        'block_suffix' => '',
        'element_prefix' => '',
        'element_suffix' => '',
    ];

    /**
     * Contain attributes that are passed to the page() method (the global attributes). If no specific attributes with
     * a share button method will be provided, these global attributes are going to be applied to all of the elements.
     */
    protected array $attributes = [];

    /**
     * @param array<string, string> $options
     *
     * @throws InvalidTemplaterFactoryArgument
     */
    public function __construct(array $options = [])
    {
        $this->initTemplater($options);
        $this->initPresenter($options);
        $this->initAttributesFormatter();

        $this->initRepresentation($options);
    }

    /**
     * @throws InvalidTemplaterFactoryArgument
     */
    protected function initTemplater(array $options): void
    {
        $this->templater = TemplaterFactory::createFromOptions($options);
    }

    protected function initPresenter(array $options): void
    {
        $this->presenter = new TemplateUrlPresenter($options);
    }

    protected function initAttributesFormatter(): void
    {
        $this->formatter = new SimpleAttributesFormatter();
    }

    protected function initRepresentation(array $options): void
    {
        $applicable = $this->retrieveApplicableOptions($options);

        $this->initBlockWrappers($applicable);
        $this->initElementWrappers($applicable);
        $this->initElementAttributes($applicable);
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveApplicableOptions(array $options): array
    {
        return array_filter($options, 'is_string');
    }

    protected function initBlockWrappers(array $options): void
    {
        $this->styling['block_prefix'] = $options['block_prefix'] ?? config('share-buttons.block_prefix', '<ul>');
        $this->styling['block_suffix'] = $options['block_suffix'] ?? config('share-buttons.block_suffix', '</ul>');
    }

    protected function initElementWrappers(array $options): void
    {
        $this->styling['element_prefix'] = $options['element_prefix'] ?? config('share-buttons.element_prefix', '<li>');
        $this->styling['element_suffix'] = $options['element_suffix'] ?? config('share-buttons.element_suffix', '</li>');
    }

    protected function initElementAttributes(array $options): void
    {
        $this->attributes = array_diff_key($options, $this->styling);
    }

    /**
     * @inheritDoc
     */
    public function refresh(array $options): void
    {
        $this->initRepresentation($options);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return $this->styling['block_prefix'];
    }

    /**
     * @inheritDoc
     */
    public function getBlockSuffix(): string
    {
        return $this->styling['block_suffix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementPrefix(): string
    {
        return $this->styling['element_prefix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementSuffix(): string
    {
        return $this->styling['element_suffix'];
    }

    /**
     * @inheritDoc
     */
    public function getElementBody(string $name, array $arguments): string
    {
        $url = $this->presenter->generateUrl($name, $arguments);

        $template = $this->retrieveElementTemplate($name);
        $replacements = $this->retrieveElementReplacements($url, $arguments);

        return $this->templater->process($template, $replacements);
    }

    protected function retrieveElementTemplate(string $name): string
    {
        return config('share-buttons.templates.' . $name, '');
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveElementReplacements(string $url, array $options): array
    {
        $replacements = ['url' => $url];
        $attributes = $this->retrieveAttributes($options);

        return array_merge(
            $replacements,
            $attributes,
        );
    }

    /**
     * @return array<string, string>
     */
    protected function retrieveAttributes(array $options): array
    {
        $attributes = array_merge($this->attributes, $options);

        return $this->formatter->format($attributes);
    }

    /**
     * @inheritDoc
     */
    public function getElementUrl(string $name, array $arguments): string
    {
        return $this->presenter->generateUrl($name, $arguments);
    }
}
