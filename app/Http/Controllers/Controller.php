<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Backward-compat shim for legacy packages (e.g. novay/sso-client) that still
     * call `$this->middleware()` in constructors. Laravel 11+ removed this method
     * from base Controller. We accept the call and silently ignore it — middleware
     * for those routes should be set in the route definition instead.
     *
     * Returns a fluent dummy that supports `->only()` and `->except()` chaining.
     */
    public function middleware($middleware, array $options = []): object
    {
        return new class {
            public function only(...$args): self { return $this; }
            public function except(...$args): self { return $this; }
        };
    }
}
