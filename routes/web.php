<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/projects/{project}/collaboration',
    [ProjectCollaborationController::class, 'show']
)->name('projects.collaboration');

Route::post(
    '/projects/{project}/members',
    [ProjectCollaborationController::class, 'addMember']
)->name('projects.members.add');
