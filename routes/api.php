<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'projects' => ProjectController::class,
    'issues'   => IssueController::class,
    'labels'   => LabelController::class,
    'comments' => CommentController::class,
    'users'    => UserController::class,
]);

Route::prefix('reports')->group(function () {

    Route::get('/projects-issues', [IssueController::class, 'projectStats']);
    Route::get('/users-issues', [IssueController::class, 'userStats']);
    Route::get('/issues-comments', [IssueController::class, 'issuesWithComments']);
    Route::get('/urgent', [IssueController::class, 'highPriority']);
    Route::get('/recently-closed', [IssueController::class, 'recentlyClosed']);
});

