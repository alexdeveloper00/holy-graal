<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class RouteGroup {
    public function __construct(
        public ?string $prefix = null,
        public array $middleware = []
    ) {
    }
}
