<?php

namespace Kudashevs\ShareButtons\Tests\ShareProviders;

use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareProviderTest extends ExtendedTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application
    }

    /** @test */
    public function it_can_create_an_instance()
    {
        $instance = Facebook::create();

        $this->assertSame('facebook', $instance->getName());
    }

    /** @test */
    public function it_can_retrieve_a_template()
    {
        $instance = Facebook::create();

        $this->assertNotEmpty($instance->getTemplate());
    }

    /** @test */
    public function it_can_retrieve_a_url()
    {
        $instance = Facebook::create();

        $this->assertNotEmpty($instance->getUrl());
    }

    /** @test */
    public function it_can_retrieve_a_text()
    {
        $instance = Facebook::create();

        $this->assertNotEmpty($instance->getText());
    }

    /** @test */
    public function it_can_create_from_a_method_call()
    {
        $page = 'https://mysite.com';
        $title = 'Page share title';
        $arguments = [
            'rel' => 'nofollow',
        ];

        $instance = Facebook::createFromMethodCall($page, $title, $arguments);

        $this->assertNotEmpty($instance->getName());
        $this->assertNotEmpty($instance->getUrl());
    }
}
