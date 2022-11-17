<?php

namespace Kudashevs\ShareButtons\Tests\Factories;

use Kudashevs\ShareButtons\Exceptions\InvalidShareProviderFactoryArgument;
use Kudashevs\ShareButtons\Factories\ShareProviderFactory;
use Kudashevs\ShareButtons\ShareProviders\Providers\Facebook;
use Kudashevs\ShareButtons\Tests\ExtendedTestCase;

class ShareProviderFactoryTest extends ExtendedTestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // it goes first to set up an application
    }

    /** @test */
    public function it_can_throw_exception_when_an_unknown_name_is_provided()
    {
        $this->expectException(InvalidShareProviderFactoryArgument::class);
        $this->expectExceptionMessage('wrong');

        ShareProviderFactory::createFromMethodCall('wrong', 'https://mysite.com', '', []);
    }

    /** @test */
    public function it_can_validate_a_share_provider_by_name()
    {
        $this->assertTrue(ShareProviderFactory::isValidProviderName('facebook'));
        $this->assertFalse(ShareProviderFactory::isValidProviderName('wrong'));
    }

    /** @test */
    public function it_can_create_a_specific_instance_from_a_method_call()
    {
        $provider = ShareProviderFactory::createFromMethodCall('facebook', 'https://mysite.com', 'title', []);

        $this->assertInstanceOf(Facebook::class, $provider);
    }
}
