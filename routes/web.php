<?php

// use App\Http\Controllers\Admin\CategoriesController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VideoController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware('auth','admin')->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('index');

    // categories route
    Route::get('Categories/trash',[CategoryController::class,'trash'])->name('catrgories.trash');
    Route::get('Categories/{id}/restore',[CategoryController::class,'restore'])->name('catrgories.restore');
    Route::delete('Categories/{id}/forcedelete',[CategoryController::class,'forceDelete'])->name('catrgories.forcedelete');
    Route::resource('categories',CategoryController::class);


    //courses routes
    Route::get('Courses/trash',[CourseController::class,'trash'])->name('courses.trash');
    Route::get('Courses/{id}/restore',[CourseController::class,'restore'])->name('courses.restore');
    Route::delete('Courses/{id}/forcedelete',[CourseController::class,'forceDelete'])->name('courses.forcedelete');
    Route::resource('courses',CourseController::class);


    //videos routes
    Route::get('videos/trash',[VideoController::class,'trash'])->name('videos.trash');
    Route::get('videos/{id}/restore',[VideoController::class,'restore'])->name('videos.restore');
    Route::delete('videos/{id}/forcedelete',[VideoController::class,'forceDelete'])->name('videos.forcedelete');
    Route::resource('videos',VideoController::class);

});

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{

Route::get('/' , [MainController::class, 'index'])->name('website.index');


// Route::get('/', function () {
//     // return bcrypt(123);``

//     return view('welcome');
// })->name('website.index');

});
