<?php

use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DashboardController,
    ForumController,
    ProfilesController,
    SearchController,
    ThreadsController,
    CategoryController};
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/category');
});

//Route::get('/dashboard', [DashboardController::class, 'index'])
//    ->middleware(['auth'])
//    ->name('dashboard');

//Route::get('/dashboard/{user}/edit', [DashboardController::class, 'edit'])
//    ->middleware(['auth','edit_user'])
//    ->name('dashboard.edit');
//
//Route::put('/dashboard/update/{user}', [DashboardController::class, 'update'])
//    ->middleware(['auth','edit_user'])
//    ->name('dashboard.update');
//
//Route::put('/dashboard/update/user/{user}', [DashboardController::class, 'updateUser'])
//    ->middleware(['auth'])
//    ->name('dashboard.updateUser');
//
//Route::delete('/dashboard/destroy/{user}', [DashboardController::class, 'destroy'])
//    ->middleware(['auth'])
//    ->name('dashboard.destroy');

Route::resource('dashboard', DashboardController::class)
    ->except('show');

Route::get('/dashboard/users', [DashboardController::class, 'showUser'] )
    ->name('showUser');

Route::get('/dashboard/{user}/change-password', [DashboardController::class, 'changePassword'])->name('change-password');

Route::post('/dashboard/{user}/change-password', [DashboardController::class, 'updatePassword'])->name('updatePassword');


Route::get('/dashboard/users/{user}', [DashboardController::class, 'editUsers'])
    ->name('dashboard.editUsers');

Route::put('/dashboard/users/{user}', [DashboardController::class, 'updateUsers'])
    ->name('dashboard.updateUsers');

Route::delete('/dashboard/users/{user}', [DashboardController::class, 'destroy'])
->name('dashboard.delete');

Route::get('/category/forum/{forum}/threads/create', [
    'as' => 'threads.create',
    'uses' => 'App\Http\Controllers\ThreadsController@create'
]);

Route::prefix('/category/forum/{forum}')->group(function () {
    Route::resource('/threads', ThreadsController::class)
        ->except('create');
});

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profiles.show');

Route::put('threads/{thread}/replies', [ThreadsController::class, 'storeReply'])
    ->name('threads.storeReply');

Route::get('threads/{thread}/replies', [ThreadsController::class, 'createReply'])
    ->name('threads.createReply');

Route::delete('threads/{thread}/destroy', [ThreadsController::class, 'destroyReply'])
    ->name('threads.destroyOneReply');

Route::resource('category', CategoryController::class);

Route::resource('/category/forum', ForumController::class);


Route::post('/attachments', function () {
    request()->validate([
        'attachment' => ['required', 'file'],
    ]);
    $path = request()->file('attachment')->store('trix-attachments', 'public');
    return [
        'image_url' => Storage::disk('public')->url($path),
    ];
})->middleware(['auth'])->name('attachments.store');


Route::get('/chat{key?}', Main::class)
    ->middleware(['auth'])
    ->name('chat');

Route::get('/users', CreateChat::class)
    ->middleware(['auth'])
    ->name('users');



require __DIR__.'/auth.php';
