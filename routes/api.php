<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\ThrottleRequests;

Route::middleware([ThrottleRequests::class . ":10,1"])->group(function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
    Route::post('/chatbot/ask', [ChatbotController::class, 'ask']);
});

Route::middleware(["auth:sanctum", ThrottleRequests::class . ":10,1"])->group(
    function () {

        // User API Routes
        Route::group(["prefix" => "user"], function () {
            Route::get("/", [UserController::class, "index"]);
            Route::get("/show/{user}", [UserController::class, "show"]);
            Route::put("/{user}", [UserController::class, "update"]);
            Route::delete("/logout/{user}", [UserController::class, "destroy"]);
        });

        // Report API Routes
        Route::group(["prefix" => "report"], function () {
            Route::get("/", [ReportController::class, "index"]);
            Route::post("/", [ReportController::class, "store"]);
            Route::get("/show/{title}", [ReportController::class, "show"]);
            Route::get("/status/{status}", [
                ReportController::class,
                "showStatus",
            ]);
            Route::put("/{title}", [ReportController::class, "update"]);
            Route::delete("/{title}", [ReportController::class, "destroy"]);
        });

        // Admin Responses API Routes
        Route::group(["prefix" => "response"], function () {
            Route::get(
                "/",
                "App\Http\Controllers\Api\Admin\ResponseController@index",
            );
            Route::post(
                "/",
                "App\Http\Controllers\Api\Admin\ResponseController@store",
            );
            Route::get(
                "/{id}",
                "App\Http\Controllers\Api\Admin\ResponseController@show",
            );
            Route::put(
                "/{id}",
                "App\Http\Controllers\Api\Admin\ResponseController@update",
            );
            Route::delete(
                "/{id}",
                "App\Http\Controllers\Api\Admin\ResponseController@destroy",
            );
        });
    },
);

Route::middleware(["auth:sanctum"])->group(function() {
    Route::group(["prefix" => "admin"], function () {
        Route::get("/stats", [AdminController::class, "dashboardStats"]);
        Route::get("/staff", [AdminController::class, "indexStaff"]);
        Route::post("/staff", [AdminController::class, "storeStaff"]);
        Route::put("/staff/{name}", [
            AdminController::class,
            "updateStaff",
        ]);
        Route::delete("/staff/{name}", [
            AdminController::class,
            "destroyStaff",
        ]);
        Route::get('/chatbot', [AdminController::class, 'indexChatbot']);
        Route::post('/chatbot', [AdminController::class, 'storeChatbot']);
        Route::put('/chatbot/{id}', [AdminController::class, 'updateChatbot']);
        Route::delete('/chatbot/{id}', [AdminController::class, 'destroyChatbot']);
    });
});
