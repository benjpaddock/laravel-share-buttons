<?php

declare(strict_types=1);

namespace Kudashevs\ShareButtons\Templaters;

/**
 * Templater represents an abstraction of a simple template engine.
 */
interface Templater
{
    /**
     * @param string $template
     * @param array $replacements
     * @return string
     */
    public function process(string $template, array $replacements): string;
}
