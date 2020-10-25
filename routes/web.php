<?php

use App\Http\Controllers\Admin\Experience_technologieController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\IllustrationController;
use App\Http\Controllers\Admin\Module_skillController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TechnologieController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkController;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

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

Route::get('template', function (){
    return view('welcome');
});

Route::get('/', function () {
    $lang = request()->getDefaultLocale();
    $lang = ($lang == 'fr' or $lang == 'en') ? $lang : 'en';
    return redirect($lang);
});

Route::get('/{lang}',               [ClientController::class, 'about']);
Route::get('/{lang}/skills',        [ClientController::class, 'skills']);
Route::get('/{lang}/experiences',   [ClientController::class, 'experiences']);
Route::get('/{lang}/others',        [ClientController::class, 'others']);
Route::get('/{lang}/blog',          [ClientController::class, 'blog']);

Route::get('/settings/{lang}', function ($lang = 'en'){

    if($lang == 'en' or $lang == 'fr'){
        $uri = request()->query('url');
        $url = preg_replace('#/(en|fr)/?#', '/'.$lang.'/', $uri);
        return redirect($url);
    }
    else
    {
        return back();
    }
});

Route::get('not_authorize', function () {
   return view('errors.not_authorize');
});

Route::get('dashboard',     [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
Route::get('login', function (){
   return view('auth.login');
});
Route::post('login',         [LoginController::class, 'authenticate'])
    ->name('login');
Route::post('logout',       [LoginController::class, 'logout'])
    ->name('logout');

// ===================================================================================================
//
//      Admins zone
//
// ===================================================================================================

Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('experience_technologies',Experience_technologieController::class);
    Route::get('testExperience_technologie', [Experience_technologieController::class, 'test']);

    Route::resource('experiences', ExperienceController::class);
    Route::get('testExperience', [ExperienceController::class, 'test']);

    Route::resource('illustrations', IllustrationController::class);
    Route::get('testIllustration', [IllustrationController::class, 'test']);

    Route::resource('module_skills', Module_skillController::class);
    Route::get('testModule_skill', [Module_skillController::class, 'test']);

    Route::resource('modules', ModuleController::class);
    Route::get('testModule', [ModuleController::class, 'test']);

    Route::resource('skills', SkillController::class);
    Route::get('testSkill', [SkillController::class, 'test']);

    Route::resource('technologies', TechnologieController::class);
    Route::get('testTechnologie', [TechnologieController::class, 'test']);

    Route::resource('users', UserController::class);
    Route::get('testUser', [UserController::class, 'test']);

    Route::resource('works', WorkController::class);
    Route::get('testWork', [WorkController::class, 'test']);

});
