<?php

use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkerBookingController;
use App\Http\Controllers\WorkerChatController;
use App\Http\Controllers\WorkerDashboardController;
use App\Http\Controllers\WorkerEarningsController;
use App\Http\Controllers\WorkerActivityController;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/categories', [ServiceController::class, 'categories']);
Route::get('/workers/{id}', [ServiceController::class, 'workerProfile']);
Route::get('/config', [WorkerDashboardController::class, 'config']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus']);
    Route::patch('/bookings/{booking}/reschedule', [BookingController::class, 'reschedule']);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    Route::get('/messages/{peerId}', [MessageController::class, 'index']);
    Route::post('/messages', [MessageController::class, 'store']);

    Route::prefix('ai')->group(function () {
        Route::get('/history', [AiAssistantController::class, 'history']);
        Route::post('/chat', [AiAssistantController::class, 'chat']);
        Route::delete('/history', [AiAssistantController::class, 'clearHistory']);
    });

    Route::middleware('role:worker')->prefix('worker')->group(function () {
        Route::get('/dashboard', [WorkerDashboardController::class, 'index']);
        Route::post('/availability', [WorkerDashboardController::class, 'toggleAvailability']);

        Route::get('/requests', [WorkerBookingController::class, 'index']);
        Route::post('/requests/{booking}/accept', [WorkerBookingController::class, 'accept']);
        Route::post('/requests/{booking}/reject', [WorkerBookingController::class, 'reject']);
        Route::post('/requests/{booking}/complete', [WorkerBookingController::class, 'complete']);
        Route::get('/requests/{booking}/location', [WorkerBookingController::class, 'customerLocation']);

        Route::get('/earnings', [WorkerEarningsController::class, 'index']);
        Route::get('/earnings/chart', [WorkerEarningsController::class, 'chartData']);

        Route::get('/chat/conversations', [WorkerChatController::class, 'conversations']);
        Route::post('/chat/{customer}/read', [WorkerChatController::class, 'markRead']);

        Route::get('/activities', [WorkerActivityController::class, 'index']);
    });
});
