<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// удаление файла
// в теле передавать pathnamehash и сорт ордер
Route::delete('/artwork/files', [
  \Source\Entity\Artwork\Controllers\ArtworkApiController::class, 'deleteArtworkImage'
])->middleware(['apikey', \Illuminate\Cookie\Middleware\EncryptCookies::class]);
Route::delete('/user/files', \Source\Entity\User\Controllers\ApiProfileController::class . '@deleteUserPicture')
    ->middleware(['apikey', \Illuminate\Cookie\Middleware\EncryptCookies::class]);
Route::delete('/resume/workplace', [\Source\Entity\Resume\Controllers\ResumeApiController::class, 'workplaceDelete'])
    ->middleware(['apikey', Illuminate\Cookie\Middleware\EncryptCookies::class]);
