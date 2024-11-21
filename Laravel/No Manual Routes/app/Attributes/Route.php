<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route {
    public function __construct(
        public string $method,
        public string $uri,
        public ?string $name = null,
        public $middleware = null,
    ) {
    }
}