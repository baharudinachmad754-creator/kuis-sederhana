<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Guru\QuizController;
use App\Http\Controllers\Guru\QuizQuestionController;
use App\Http\Controllers\Guru\QuizHistoryController as GuruQuizHistoryController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\Siswa\QuizPlayController;
use App\Http\Controllers\Siswa\QuizHistoryController;
use App\Http\Middleware\RoleMiddleware;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'guru' => redirect()->route('guru.quizzes.index'),
        'siswa' => redirect()->route('siswa.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| GURU ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

        Route::delete(
            '/history/attempt/{attempt}',
            [GuruQuizHistoryController::class, 'destroy']
        )->name('history.delete');

        Route::get('/history', [\App\Http\Controllers\Guru\QuizHistoryController::class, 'index'])
            ->name('history.index');

        Route::get('/history/mapel/{category}', [\App\Http\Controllers\Guru\QuizHistoryController::class, 'quizzes'])
            ->name('history.quizzes');

        Route::get('/history/quiz/{quiz}', [\App\Http\Controllers\Guru\QuizHistoryController::class, 'tokenForm'])
            ->name('history.token');

        Route::post('/history/quiz/{quiz}', [\App\Http\Controllers\Guru\QuizHistoryController::class, 'verifyToken'])
            ->name('history.verify');


        Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
        Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit');
        Route::post('/quizzes/{quiz}/publish', [QuizController::class, 'publish'])->name('quizzes.publish');
        Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy');

        Route::get('/quizzes/{quiz}/questions/create', [QuizQuestionController::class, 'create'])->name('quizzes.questions.create');
        Route::post('/quizzes/{quiz}/questions', [QuizQuestionController::class, 'store'])->name('quizzes.questions.store');
        Route::get('/quizzes/{quiz}/questions/{question}/edit', [QuizQuestionController::class, 'edit'])->name('quizzes.questions.edit');
        Route::put('/quizzes/{quiz}/questions/{question}', [QuizQuestionController::class, 'update'])->name('quizzes.questions.update');
        Route::delete('/quizzes/{quiz}/questions/{question}', [QuizQuestionController::class, 'destroy'])->name('quizzes.questions.destroy');
    });

/*
|--------------------------------------------------------------------------
| SISWA ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('siswa')
    ->name('siswa.')
    ->middleware(['auth', RoleMiddleware::class . ':siswa'])
    ->group(function () {

        // Verifikasi token
        Route::post('/quiz/{quiz}/verify-token', [QuizPlayController::class, 'verifyToken'])
            ->name('quiz.verify-token');

        // Dashboard siswa
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
            ->name('dashboard');

        // History siswa
        Route::get('/history', [QuizHistoryController::class, 'index'])
            ->name('history');

        // Daftar quiz per kategori
        Route::get('/mapel/{category}', [SiswaDashboardController::class, 'byCategory'])
            ->name('mapel.quizzes');

        // Play quiz
        Route::get('/quiz/{quiz}/play', [QuizPlayController::class, 'play'])
            ->name('quiz.play');

        // Submit quiz
        Route::post('/quiz/{quiz}/submit', [QuizPlayController::class, 'submit'])
            ->name('quiz.submit');
    });
