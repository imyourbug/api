<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Users\LoginController;
use  App\Http\Controllers\Users\RegisterController;
use  App\Http\Controllers\Users\ConversationController;
use  App\Http\Controllers\Users\ConversationMessageController;
use  App\Http\Controllers\Users\ConversationSettingController;
use  App\Http\Controllers\Users\UserController;

Route::prefix('/auth')->group(function () {
    #login
    Route::prefix('/login')->group(function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/', [LoginController::class, 'store'])->name('login.store');
    });
    #register
    Route::prefix('/register')->group(function () {
        Route::post('/', [RegisterController::class, 'store']);
    });
});
// middleware(['auth'])
Route::middleware(['auth:api'])->group(function () {
    Route::prefix('/chat')->group(function () {
        #conversations
        Route::prefix('/conversations')->group(function () {
            #bỏ qua
            Route::get('/', [ConversationController::class, 'index'])->name('conversations.index');
            #data
            Route::get('/data', [ConversationController::class, 'data'])->name('conversations.data');
            #add
            Route::post('/add', [ConversationSettingController::class, 'add']);
            #remove
            Route::delete('/remove', [ConversationSettingController::class, 'remove']);
            #join
            Route::post('/join', [ConversationSettingController::class, 'join'])->name('conversations.join');
            #leave
            Route::delete('/leave', [ConversationSettingController::class, 'leave'])->name('conversations.leave');
            #create
            Route::post('/create', [ConversationController::class, 'create'])->name('conversations.create');
            #change conversation name
            Route::post('/update', [ConversationController::class, 'update'])->name('conversations.update');
            #destroy
            Route::delete('/destroy', [ConversationController::class, 'destroy'])->name('conversations.destroy');
        });
        #messages
        Route::prefix('/messages')->group(function () {
            #get messages by id_conversation
            Route::get('/', [ConversationMessageController::class, 'index']);
        });
    });
    Route::prefix('/users')->group(function () {
        #get list users
        Route::get('/list', [UserController::class, 'list'])->name('users.list');
        #search user by name
        Route::post('/search', [UserController::class, 'search'])->name('users.search');
    });
});
