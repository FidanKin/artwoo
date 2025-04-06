<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Source\Entity\User\Models\User;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index']);

Route::get('/signup', [Source\Auth\Controllers\SignupController::class, 'render'])
    ->middleware('guest');
Route::post('/signup', [Source\Auth\Controllers\SignupController::class, 'store']);

Route::get('/login', [Source\Auth\Controllers\AuthorizationController::class, 'render'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [Source\Auth\Controllers\AuthorizationController::class, 'login']);

Route::prefix('my')
    ->middleware(['auth', 'verified'])
    ->group(function() {
        Route::get('/', [\Source\Entity\User\Controllers\ProfileController::class,'getRender'])->name('my.profile');
        Route::post('/edit', [\Source\Entity\User\Controllers\ProfileController::class, 'updateProfile']);
        Route::get('/edit', [\Source\Entity\User\Controllers\ProfileController::class,'editProfile']);
});

Route::get('/logout', function(\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->middleware('auth');

Route::group(['prefix' => 'author', 'controller' => \Source\Entity\User\Controllers\AuthorController::class], function() {
    Route::get('/{id}', 'author');
    Route::get('/', 'authors');
    Route::post('/delete/{id}', 'accountDelete');
});

/**
 * ===========================================
 * Подтверждение аккаунта по электронной почте
 * ===========================================
 */
Route::get('/email/verify', function(User $user) {
    if ($user->hasVerifiedEmail()) {
        return redirect('/my');
    }
    return view('pages.auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/my');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', __('auth.verification_code_send')); // поправить текст
})->middleware(['auth', 'throttle:1,1'])->name('verification.send');
/**
 * ====================================================
 * END
 * ====================================================
 */

/**
 * ======================================
 * Сброс пароля
 * ======================================
 */
Route::get('/forgot-password', fn() => view('pages.auth.forgot-password'))->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', function(Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest');

Route::get('/reset-password/{token}', [\Source\Auth\Controllers\ResetPasswordController::class, 'resetRender'])
    ->middleware('guest')->name('password.reset');

Route::post('/reset-password', [\Source\Auth\Controllers\ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');
/**
 * ====================================
 * Конец сброса пароля
 * ====================================
 */

Route::prefix('/resume')
    ->group(function () {
        Route::group(['middleware' => ['auth', 'verified']], function() {
            Route::get('/edit', [\Source\Entity\Resume\Controllers\ResumeController::class, 'getEditPage']);
            Route::post('/workplace', [\Source\Entity\Resume\Controllers\ResumeController::class, 'workplaceSave'])
                ->middleware('can:content-create');
            Route::post('/edit', [\Source\Entity\Resume\Controllers\ResumeController::class, 'resumeSave'])
                ->middleware('can:content-create');
            Route::get('/{id?}', [\Source\Entity\Resume\Controllers\ResumeController::class, 'index']);
        });
    });

// ========== ARTWORKS ============
Route::get('/artwork/edit/{id?}', [\Source\Entity\Artwork\Controllers\ArtworkController::class, 'getEditRender'])
    ->middleware(['auth', 'verified', 'can:content-create']);
Route::get('/artwork/sort/{id}', [\Source\Entity\Artwork\Controllers\ArtworkController::class, 'getSortingPage'])
    ->middleware(['auth', 'verified', 'can:content-create']);
Route::post('/artwork/sort/{id}', [\Source\Entity\Artwork\Controllers\ArtworkController::class, 'saveSorting'])
    ->middleware(['auth', 'verified', 'can:content-create']);
Route::post('/artwork/edit/{id?}', [\Source\Entity\Artwork\Controllers\ArtworkController::class, 'save'])
    ->middleware(['auth', 'verified', 'can:content-create']);
Route::post("artwork/delete/{id}", [\Source\Entity\Artwork\Controllers\ArtworkController::class, 'deleteAction'])
    ->middleware(['auth', 'verified']);
Route::get('/artwork/{id}', [\Source\Entity\Artwork\Controllers\ArtworkController::class, 'getAuthorView']);

// ========== FILEMANAGER ============
Route::get('filesmanager/{pathnamehash}', function(string $pathnamehash) {
    $fs = new \Source\Lib\FileStorage();
    $filepath = $fs->getFileRealPath($pathnamehash);
    if ($filepath) {
        return response()->file($filepath);
    }

    abort(404);
});

Route::prefix('blog')->group(function () {
    Route::get('about', fn() => view('pages/blog/about'));
    Route::get('founders', fn() => view('pages/blog/founders'));
    Route::get('donation', fn() => view('pages/blog/donation'));
    Route::get('feedback', fn() => view('pages/blog/feedback'));
    Route::get('/', fn() => view('pages/blog/all'));
});

Route::group([
  'middleware' => ['auth', 'verified', 'can:content-create'], 'prefix' => 'chat', 'controller' => \Source\Entity\Chat\Controllers\ChatController::class
], function() {
    // Переписка id - идентификатор чата
    Route::get("/{id}", "showMessages")->middleware('user.in_chat');
    // отобразить интерфейс списка чатов
    Route::get("/", "index");
    Route::post("/", "createChat");
    Route::post("/message", "addMessage");
    Route::post("/{id}/delete", "deleteChat")->middleware('user.in_chat');
});
Route::group([
  'middleware' => ['auth', 'verified'],
  'prefix' => '/reference',
  'controller' => \Source\Entity\Reference\Controllers\ReferenceController::class
  ], function() {
    Route::get("/", 'index');
    Route::get("/folder/{id}", 'folderShow');
    Route::post("/folder", "createFolder");
    Route::post("/folder/{id}", "uploadReferences");
    Route::post("/item/delete/{id}", "itemDelete");
    Route::post("/folder/delete/{id}", "folderDelete");
});

Route::get("modal-test", function() {
    return view('pages/modal-test');
});

/**
 * =====================================
 * === Модерация =======================
 * =====================================
 */
Route::middleware(['auth', 'moderator'])->prefix('admin')
    ->controller(\Source\Entity\Admin\Controllers\ModeratorController::class)
    ->group(function() {
        Route::prefix('moderation')->group(function() {
            Route::get("/users", 'usersModeration');
            Route::post('/users', 'usersModerationAction');
            Route::get('/artworks', 'artworksModeration');
            Route::post('/artworks', 'artworksModerationAction');
        });
});
/**
 * =====================================
 * === Конец модерации =================
 * =====================================
 */

Route::prefix('pages/')->group(function() {
   Route::get('privacy-policy', fn() =>  view('pages/info/privacy-policy'));
   Route::get('privacy-cookie', fn() => view('pages/info/privacy-cookie'));
   Route::get('/contacts', fn() => view('pages/info/contact'));
});

if (config('app.debug') === false) {
    Route::fallback(function () {
        abort(404);
    });
}



