<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MasterDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminExamController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserExamController;



/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Google Authentication
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [
    GoogleAuthController::class,
    'redirect'
])->name('google.login');

Route::get('/auth/google/callback', [
    GoogleAuthController::class,
    'callback'
])->name('google.callback');


/*
|--------------------------------------------------------------------------
| Central Dashboard Redirect
|--------------------------------------------------------------------------
|
| After login, Laravel sends the user here.
| We check the user's role and send them to
| the appropriate dashboard.
|
*/
Route::get('/dashboard', function () {

    $user = auth()->user();

    return match ($user->role) {

        'master_admin' => redirect()->route('master.dashboard'),

        'admin' => redirect()->route('admin.dashboard'),

        'user' => redirect()->route('user.dashboard'),

        default => abort(403),

    };

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Master Admin Routes
|--------------------------------------------------------------------------
|
| Only users with role = master_admin can access these routes.
|
*/

Route::middleware(['auth', 'role:master_admin'])
    ->prefix('master')
    ->name('master.')
    ->group(function () {

        Route::get('/dashboard', [
            MasterDashboardController::class,
            'index'
        ])->name('dashboard');

    });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Admin and Master Admin can access these routes.
|
*/

Route::middleware(['auth', 'role:admin,master_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');


        /*
         * Exams
         */

		Route::get('/exams/create', [
            AdminExamController::class,
            'create'
        ])->name('exams.create');
		
        Route::get('/exams', [
            AdminExamController::class,
            'index'
        ])->name('exams.index');


        
		
		Route::get('/exams/{exam}', [
			AdminExamController::class,
			'show'
		])->name('exams.show');


        Route::post('/exams', [
            AdminExamController::class,
            'store'
        ])->name('exams.store');
		
		Route::patch('/exams/{exam}/toggle-status', [
			AdminExamController::class,
			'toggleStatus'
		])->name('exams.toggle-status');
		
		/*
         * Users
         */
		
		Route::get('/users', [
			AdminUserController::class,
			'index'
		])->name('users.index');

		Route::get('/users/{user}', [
			AdminUserController::class,
			'show'
		])->name('users.show');

		Route::get('/users/{user}/edit', [
			AdminUserController::class,
			'edit'
		])->name('users.edit');

    });


/*
|--------------------------------------------------------------------------
| Normal User Routes
|--------------------------------------------------------------------------
|
| Only normal users with role = user can access these routes.
|
*/
Route::prefix('user/exams')
    ->name('user.exams.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', [
            UserExamController::class,
            'index'
        ])->name('index');

        Route::get('/{exam}/instructions', [
            UserExamController::class,
            'instructions'
        ])->name('instructions');

        Route::post('/{exam}/start', [
            UserExamController::class,
            'start'
        ])->name('start');

        Route::get('/attempt/{attempt}', [
            UserExamController::class,
            'take'
        ])->name('take');

        Route::post('/attempt/{attempt}/answer', [
            UserExamController::class,
            'saveAnswer'
        ])->name('answer');

        Route::post('/attempt/{attempt}/submit', [
            UserExamController::class,
            'submit'
        ])->name('submit');

        Route::get('/attempt/{attempt}/result', [
            UserExamController::class,
            'result'
        ])->name('result');

        Route::get('/{exam}', [
            UserExamController::class,
            'show'
        ])->name('show');
    });
	
Route::middleware(['auth', 'role:user'])
					->prefix('user')
					->name('user.')
					->group(
	function () 
	{

        Route::get('/dashboard', [
            UserDashboardController::class,
            'index'
        ])->name('dashboard');

        Route::get('/settings', [
            UserDashboardController::class,
            'settings'
        ])->name('settings');

        Route::get('/attempted', [
            UserDashboardController::class,
            'attempted'
        ])->name('attempted');

        Route::get('/profile/edit', [
            UserProfileController::class,
            'edit'
        ])->name('profile.edit');

        Route::put('/profile', [
            UserProfileController::class,
            'update'
        ])->name('profile.update');

    });


Route::middleware('auth')->group(function () {

    // =====================================================
    // PROFILE
    // =====================================================

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::get('/profile/edit', [
    UserProfileController::class,
    'edit'
    ])->name('user.profile.edit');

    Route::put('/profile', [
        UserProfileController::class,
        'update'
    ])->name('user.profile.update');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');


    // =====================================================
    // USER EXAMS
    // =====================================================

    // Available exams
	
	// Attempted exams / exam history
    Route::get(
        '/user/exams/attempted',
        [UserExamController::class, 'attempted']
    )->name('user.exams.attempted');
	
    Route::get(
        '/user/exams',
        [UserExamController::class, 'index']
    )->name('user.exams.index');


    // Exam details
    Route::get(
        '/user/exams/{exam}',
        [UserExamController::class, 'show']
    )->name('user.exams.show');


    // Exam instructions
    Route::get(
        '/user/exams/{exam}/instructions',
        [UserExamController::class, 'instructions']
    )->name('user.exams.instructions');


    // Start exam
    Route::post(
        '/user/exams/{exam}/start',
        [UserExamController::class, 'start']
    )->name('useuser.profile.updater.exams.start');


    // Exam attempt page
    Route::get(
        '/user/exam-attempt/{attempt}',
        [UserExamController::class, 'take']
    )->name('user.exams.take');


    // Save answer
    Route::post(
        '/user/exam-attempt/{attempt}/answer',
        [UserExamController::class, 'saveAnswer']
    )->name('user.exams.answer');


    // Submit exam
    Route::post(
        '/user/exam-attempt/{attempt}/submit',
        [UserExamController::class, 'submit']
    )->name('user.exams.submit');


    // Exam result/report
    Route::get(
        '/user/exam-attempt/{attempt}/result',
        [UserExamController::class, 'result']
    )->name('user.exams.result');

    Route::post('/user/exams/{exam}/start', [UserExamController::class, 'start'])
    ->name('user.exams.start');


});
require __DIR__.'/auth.php';
