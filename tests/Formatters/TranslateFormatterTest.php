<?php

namespace Kudashevs\ShareButtons\Tests\Formatters;

use Kudashevs\ShareButtons\Formatters\TranslateFormatter;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class TranslateFormatterTest extends ExtendedTestCase
{
    /**
     * @var TranslateFormatter
     */
    private $formatter;

    protected function setUp(): void
    {
        parent::setUp(); // it goes first to initialize a container

        $this->formatter = new TranslateFormatter();
    }

    /** @test */
    public function it_can_setup_font_awesome_version()
    {
        $this->formatter->updateOptions(['fontAwesomeVersion' => 3]);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame(3, $result['formatter_version']);
    }

    /** @test */
    public function it_can_return_default_font_awesome_version_on_empty_option()
    {
        $version = config('share-buttons.fontAwesomeVersion');

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame($version, $result['formatter_version']);
    }

    /** @test */
    public function it_can_return_default_font_awesome_version_on_wrong_option()
    {
        $version = config('share-buttons.fontAwesomeVersion');
        $this->formatter->updateOptions(['fontAwesomeVersion' => 'wrong']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('formatter_version', $result);
        $this->assertSame($version, $result['formatter_version']);
    }

    /** @test */
    public function it_can_setup_block_prefix()
    {
        $this->formatter->updateOptions(['block_prefix' => '<div>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame('<div>', $result['block_prefix']);
    }

    /** @test */
    public function it_can_return_default_block_prefix_on_empty_option()
    {
        $default = config('share-buttons.block_prefix');
        $this->formatter->updateOptions(['block_prefix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_prefix', $result);
        $this->assertSame($default, $result['block_prefix']);
    }

    /** @test */
    public function it_can_setup_block_suffix()
    {
        $this->formatter->updateOptions(['block_suffix' => '</div>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame('</div>', $result['block_suffix']);
    }

    /** @test */
    public function it_can_return_default_block_suffix_on_empty_option()
    {
        $default = config('share-buttons.block_suffix');
        $this->formatter->updateOptions(['block_suffix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('block_suffix', $result);
        $this->assertSame($default, $result['block_suffix']);
    }

    /** @test */
    public function it_can_setup_element_prefix()
    {
        $this->formatter->updateOptions(['element_prefix' => '<p>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_prefix', $result);
        $this->assertSame('<p>', $result['element_prefix']);
    }

    /** @test */
    public function it_can_return_default_element_prefix_on_empty_option()
    {
        $default = config('share-buttons.element_prefix');
        $this->formatter->updateOptions(['element_prefix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_prefix', $result);
        $this->assertSame($default, $result['element_prefix']);
    }

    /** @test */
    public function it_can_setup_element_suffix()
    {
        $this->formatter->updateOptions(['element_suffix' => '</p>']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_suffix', $result);
        $this->assertSame('</p>', $result['element_suffix']);
    }

    /** @test */
    public function it_can_return_default_element_suffix_on_empty_option()
    {
        $default = config('share-buttons.element_suffix');
        $this->formatter->updateOptions(['element_suffix' => '']);

        $result = $this->formatter->getOptions();

        $this->assertArrayHasKey('element_suffix', $result);
        $this->assertSame($default, $result['element_suffix']);
    }

    /** @test */
    public function it_can_format_a_url_with_default_styling()
    {
        $expected = '<li><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></li>';

        $result = $this->formatter->generateUrl('facebook', 'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com', []);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function it_can_format_a_url_with_custom_styling_from_formatter()
    {
        $this->formatter->updateOptions(['element_prefix' => '<p>', 'element_suffix' => '</p>']);

        $expected = '<p><a href="https://www.facebook.com/sharer/sharer.php?u=https://mysite.com" class="social-button"><span class="fab fa-facebook-square"></span></a></p>';

        $result = $this->formatter->generateUrl('facebook', 'https://www.facebook.com/sharer/sharer.php?u=https://mysite.com', []);

        $this->assertNotEmpty($result);
        $this->assertEquals($expected, $result);
    }
}
