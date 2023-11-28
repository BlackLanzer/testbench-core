<?php

namespace Orchestra\Testbench\Attributes;

use Attribute;
use Closure;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class DefineRoute
{
    /**
     * The target method.
     *
     * @var string
     */
    public $method;

    /**
     * Construct a new attribute.
     *
     * @param  string  $method
     */
    public function __construct(string $method)
    {
        $this->method = $method;
    }

    /**
     * Handle the attribute.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @param  \Closure():void  $action
     */
    public function handle($app, Closure $action): void
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = $app->make('router');

        \call_user_func($action, $this->method, [$router]);
    }
}
