<?php

namespace Kudashevs\ShareButtons;

use Kudashevs\ShareButtons\Formatters\Formatter;
use Kudashevs\ShareButtons\ShareProviders\Factory;

/**
 * @todo don't forget to update these method signatures
 *
 * @method ShareButtons facebook(array $options = [])
 * @method ShareButtons linkedin(array $options = [])
 * @method ShareButtons pinterest(array $options = [])
 * @method ShareButtons reddit(array $options = [])
 * @method ShareButtons telegram(array $options = [])
 * @method ShareButtons twitter(array $options = [])
 * @method ShareButtons vkontakte(array $options = [])
 * @method ShareButtons whatsapp(array $options = [])
 */
class ShareButtons
{
    /**
     * The url of a page to share.
     *
     * @var string
     */
    protected $url;

    /**
     * Optional text for Twitter and Linkedin title.
     *
     * @var string
     */
    protected $title;

    /**
     * @var Formatter
     */
    private $formatter;

    /**
     * Extra options for the share links.
     *
     * @var array
     */
    protected $options = [
        'reactOnErrors' => null,
        'throwException' => null,
    ];

    /**
     * Contain share providers instances.
     *
     * @var array
     */
    private $providers = [];

    /**
     * Contain generated urls.
     *
     * @var string
     */
    protected $generatedUrls = [];

    /**
     * Contain generated representation.
     *
     * @var array
     */
    protected $generatedRepresentation = [];

    /**
     * Share constructor.
     *
     * @param Formatter $formatter
     * @param array $options
     */
    public function __construct(Formatter $formatter, array $options = [])
    {
        $this->initOptions($options);

        $this->formatter = $formatter;
        $this->formatter->updateOptions($options);

        $this->initProviders();
    }

    /**
     * @param array $options
     */
    private function initOptions(array $options = []): void
    {
        $allowed = array_intersect_key($options, $this->options);

        $this->options = array_merge($this->options, $allowed);
    }

    /**
     * Initialize share providers.
     *
     * @return void
     */
    private function initProviders(): void
    {
        $this->providers = Factory::create();
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function page(string $url, string $title = '', array $options = []): self
    {
        $this->clearState();

        $this->url = $url;
        $this->title = $title;

        $this->formatter->updateOptions($options);

        return $this;
    }

    /**
     * Clear the state of a previous call.
     */
    private function clearState(): void
    {
        $this->generatedUrls = [];
        $this->generatedRepresentation = [];
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function createForPage(string $url, string $title = '', array $options = []): self
    {
        return $this->page($url, $title, $options);
    }

    /**
     * @param string $title
     * @param array $options
     * @return $this
     */
    public function createForCurrentPage(string $title = '', array $options = []): self
    {
        $url = request()->getUri();

        return $this->page($url, $title, $options);
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     * @throws \Error
     */
    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->providers)) {
            $normalizedArguments = $this->normalizeArguments($arguments);

            $url = $this->providers[$name]->buildUrl(
                $this->url,
                $this->title,
                $normalizedArguments
            );

            $this->rememberProcessed($name, $url, $normalizedArguments);

            return $this;
        }

        if ($this->options['reactOnErrors'] === true) {
            $exception = $this->options['throwException'];
            throw new $exception('Call to undefined method ' . $this->getShortClassName($this) . '::' . $name . '()');
        }

        return $this;
    }

    /**
     * @param array $arguments
     * @return array
     */
    private function normalizeArguments(array $arguments): array
    {
        if (empty($arguments) || !isset($arguments[0])) {
            return [];
        }

        if (is_array($arguments[0])) {
            return $arguments[0];
        }

        return [];
    }

    /**
     * @param object $object
     * @return string
     */
    private function getShortClassName(object $object): string
    {
        $parsed = explode('\\', get_class($object));

        return end($parsed);
    }

    /**
     * Build a single link.
     *
     * @param string $provider
     * @param string $url
     * @param array $options
     */
    protected function rememberProcessed(string $provider, string $url, array $options = []): void
    {
        $this->rememberRawLink($provider, $url);

        $this->rememberRepresentation($provider, $url, $options);
    }

    /**
     * Remember a processed link.
     *
     * @param string $provider
     * @param string $link
     */
    protected function rememberRawLink(string $provider, string $link): void
    {
        $this->generatedUrls[$provider] = $link;
    }

    /**
     * Remember a processed representation.
     *
     * @param string $provider
     * @param string $url
     * @param array $options
     */
    protected function rememberRepresentation(string $provider, string $url, $options = []): void
    {
        $this->generatedRepresentation[$provider] = $this->formatter->generateUrl($provider, $url, $options);
    }

    /**
     * Return generated raw links.
     *
     * @return array
     */
    public function getRawLinks(): array
    {
        return $this->generatedUrls;
    }

    /**
     * Return the prepared share buttons HTML code.
     *
     * @return string
     */
    public function getShareButtons(): string
    {
        $representation = '';

        $representation .= $this->formatter->getOptions()['block_prefix'];
        foreach ($this->generatedRepresentation as $link) {
            $representation .= $link;
        }
        $representation .= $this->formatter->getOptions()['block_suffix'];

        return $representation;
    }

    /**
     * Return a string with generated HTML code.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getShareButtons();
    }
}
