<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Transactions\Infra\Controllers\Transaction\ProcessTransactionController;
use Src\Users\Infra\Controllers\Auth\LoginController;
use Src\Users\Infra\Controllers\User\CreateUserController;
use Src\Users\Infra\Controllers\User\GetUserTypeController;
use Src\Wallets\Infra\Controllers\Wallet\GetBalanceWalletController;

Route::post('/user', [CreateUserController::class, 'execute']);
Route::post('/login', [LoginController::class, 'execute']);
Route::middleware('auth:sanctum')->get('/wallet/balance/{id}', [GetBalanceWalletController::class, 'execute']);
Route::middleware('auth:sanctum')->get('/user/type/{id}', [GetUserTypeController::class, 'execute']);
Route::middleware('auth:sanctum')->post('/transfer', [ProcessTransactionController::class, 'execute']);

