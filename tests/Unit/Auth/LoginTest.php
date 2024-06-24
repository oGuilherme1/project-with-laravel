<?php

declare(strict_types=1);

namespace Tests\Unit\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Src\Users\Application\DTOs\Login\LoginInputDto;
use Src\Users\Application\UseCases\Auth\LoginGateway;
use Src\Users\Application\UseCases\Auth\LoginUseCase;


class LoginTest extends TestCase
{
    private $loginGateway;
    private $loginUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loginGateway = $this->createMock(LoginGateway::class);
        $this->loginUseCase = LoginUseCase::create($this->loginGateway);
    }

    public function testExecuteSuccessfulLogin(): void
    {
        $request = Request::create('/login', 'POST', ['email' => 'user@example.com', 'password' => 'password']);
        $loginInputDto = LoginInputDto::create($request);

        $tokenResponse = new JsonResponse(['token' => 'sample_token']);

        $this->loginGateway
            ->method('login')
            ->with($this->equalTo($request))
            ->willReturn($tokenResponse);

        $result = $this->loginUseCase->execute($loginInputDto);

        $this->assertTrue($result['status']);
        $this->assertEquals('sample_token', $result['token']);
    }

    public function testExecuteFailedLogin(): void
    {
        $request = Request::create('/login', 'POST', ['email' => 'user@example.com', 'password' => 'wrongpassword']);
        $loginInputDto = LoginInputDto::create($request);

        $this->loginGateway
            ->method('login')
            ->with($this->equalTo($request))
            ->willThrowException(new Exception('Invalid credentials'));

        $result = $this->loginUseCase->execute($loginInputDto);

        $this->assertFalse($result['status']);
        $this->assertEquals('Invalid credentials', $result['error']);
    }
}
