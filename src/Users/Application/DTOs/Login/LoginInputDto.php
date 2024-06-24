<?php

declare(strict_types=1);

namespace Src\Users\Application\DTOs\Login;

use Illuminate\Http\Request;

class LoginInputDto 
{
    private function __construct(
        private readonly Request $request,
    )
    {
        
    }

    public static function create(Request $request): self
    {
        return new self(
            request: $request,
        );
    }

    public function getRequest() 
    {
        return $this->request;
    }

}