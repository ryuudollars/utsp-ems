<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Admin
Route::prefix('admin')->group(function() {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login.submit');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:web_admin']], function(){

    // HOME
    Route::get('/home', 'AdminController@index')->name('admin.home');
    Route::put('/info', 'AdminController@editInfo');
    Route::put('/username', 'AdminController@changeUsername');
    Route::put('/password', 'AdminController@changePassword');

    // USER
    Route::get('/user', 'AdminController@user')->name('admin.user');
    Route::get('/dashboard', 'AdminController@dashboardView');
    Route::get('/view', 'AdminController@infoView');

    // ASSIGN
    Route::post('/assign/create', 'AdminController@assignCreate');
    Route::put('/assign/update', 'AdminController@assignUpdate');
    Route::post('/assign/delete', 'AdminController@assignDelete');

    // STUDENT
    Route::post('/student/create', 'AdminController@studentCreate');
    Route::put('/student/update', 'AdminController@studentUpdate');
    Route::post('/student/delete', 'AdminController@studentDelete');

    // FACULTY
    Route::get('/faculty/view', 'AdminController@facultyView');
    Route::post('/faculty/create', 'AdminController@facultyCreate');
    Route::put('/faculty/update', 'AdminController@facultyUpdate');
    Route::post('/faculty/delete', 'AdminController@facultyDelete');

    // SCHOOL
    Route::get('/school', 'AdminController@school')->name('admin.school');
    Route::get('/school/view', 'AdminController@schoolView');
    // DEPARTMENT
    Route::post('/department/create', 'AdminController@departmentCreate');
    Route::put('/department/update', 'AdminController@departmentUpdate');
    Route::post('/department/delete', 'AdminController@departmentDelete');
    // POSITION
    Route::post('/position/create', 'AdminController@positionCreate');
    Route::put('/position/update', 'AdminController@positionUpdate');
    Route::post('/position/delete', 'AdminController@positionDelete');
    // SECTION
    Route::post('/section/create', 'AdminController@sectionCreate');
    Route::put('/section/update', 'AdminController@sectionUpdate');
    Route::post('/section/delete', 'AdminController@sectionDelete');
    // ACADEMIC
    Route::post('/academic/create', 'AdminController@academicCreate');
    Route::put('/academic/update', 'AdminController@academicUpdate');
    Route::post('/academic/delete', 'AdminController@academicDelete');
    // SEMESTER
    Route::post('/semester/create', 'AdminController@semesterCreate');
    Route::put('/semester/update', 'AdminController@semesterUpdate');
    Route::post('/semester/delete', 'AdminController@semesterDelete');
    // SUBJECT
    Route::post('/subject/create', 'AdminController@subjectCreate');
    Route::put('/subject/update', 'AdminController@subjectUpdate');
    Route::post('/subject/delete', 'AdminController@subjectDelete');

    // EVALAUTION
    Route::get('/evaluation', 'AdminController@evaluation')->name('admin.evaluation');
    Route::get('/evaluation/view', 'AdminController@evaluationView');
    // QUESTION
    Route::post('/question/create', 'AdminController@questionCreate');
    Route::put('/question/update', 'AdminController@questionUpdate');
    // EVALUATION FORM
    Route::post('/evaluation/create', 'AdminController@evaluationCreate');
    Route::put('/evaluation/update', 'AdminController@evaluationUpdate');
    // QUESTIONFORM
    Route::post('/evaluation/question/create', 'AdminController@questionformCreate');
    Route::post('/evaluation/question/delete', 'AdminController@questionformDelete');
    // EVALUATOR STUDENT
    Route::post('/section/evaluator/create', 'AdminController@sectionEvaluatorCreate');
    Route::post('/section/evaluator/delete', 'AdminController@sectionEvaluatorDelete');

    // POST
    Route::post('/post', 'AdminController@postAnnouncement');
    Route::post('/delete/post', 'AdminController@postDelete');

    // LOGOUT
    Route::post('/logout', 'AdminController@logout')->name('logout');
});

// Faculty
Route::prefix('faculty')->group(function() {
    Route::get('/login', 'FacultyAuth\LoginController@showLoginForm')->name('faculty.login');
    Route::post('/login', 'FacultyAuth\LoginController@login')->name('faculty.login.submit');

});

Route::group(['prefix' => 'faculty', 'middleware' => ['auth:web_faculty']], function(){
    Route::get('/home', 'FacultyController@index')->name('faculty.home');
    Route::put('/info', 'FacultyController@editInfo');

    // POST
    Route::get('/post', 'FacultyController@postView');

    // LOGOUT
    Route::post('/logout', 'FacultyController@logout')->name('logout');
});

// STUDENT
Route::prefix('student')->group(function() {
    Route::get('/login', 'StudentAuth\LoginController@showLoginForm')->name('student.login');
    Route::post('/login', 'StudentAuth\LoginController@login')->name('student.login.submit');
});

Route::group(['prefix' => 'student', 'middleware' => ['auth:web_student']], function(){
    Route::get('/home', 'StudentController@index')->name('student.home');
    Route::put('/info', 'StudentController@editInfo');

    // EVALUATION
    Route::get('/evaluation', 'StudentController@evaluation')->name('student.evaluation');
    Route::get('/teacher/evaluation', 'StudentController@teacherEvaluationView');
    Route::post('/teacher/evaluation', 'StudentController@teacherEvaluationCreate');

    // POST
    Route::get('/post', 'StudentController@postView');

    // LOGOUT
    Route::post('/logout', 'StudentController@logout')->name('logout');
});
