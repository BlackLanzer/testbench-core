<?php

namespace Orchestra\Testbench\Tests\Integrations;

use Orchestra\Testbench\TestCase;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

use function Orchestra\Testbench\package_path;
use function Orchestra\Testbench\remote;

class ArtisanTest extends TestCase
{
    /**
     * @test
     *
     * @group core
     */
    public function it_can_generate_the_same_output()
    {
        $phpBinary = \defined('PHP_BINARY') ? PHP_BINARY : (new PhpExecutableFinder)->find();

        $remote = remote('--version --no-ansi')->mustRun();

        $artisan = (new Process(
            [$phpBinary, 'artisan', '--version', '--no-ansi'],
            package_path('laravel')
        ))->mustRun();

        $this->assertSame(json_decode($artisan->getOutput(), true), json_decode($remote->getOutput(), true));
    }
}
