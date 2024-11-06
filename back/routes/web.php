<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\UserController ;


use Illuminate\Support\Facades\Auth;


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
Route::get('/logout' , [AuthController::class,'logout'])->name('logout');
 Route::get('/', action: [AdminController::class,'index'])->name('index');
Route::get('/home', [AdminController::class, 'home'])->name('home');

Route::get('/project', [AdminController::class, 'project'])->name('project');
Route::get('/register', [AuthController::class,'show_reg'])->name('show_reg');
Route::post('/register', [AuthController::class,'signup'])->name('signup');
Route::get('/login', [AuthController::class,'show_signin'])->name('show_signin');
Route::post('/login', [AuthController::class,'signin'])->name('login');


Route::delete('/usersdestroy/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
Route::get('/infoTask/{id}', [AdminController::class, 'infoTask'])->name('infoTask');

// обновление пользователей 
Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('adminUpdateUser');
Route::patch('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
// обновление проекта
Route::get('/project/{id}/edit', [AdminController::class, 'editProject'])->name('adminUpdateProject');  
Route::put('/adminUpdateProject/{id}', [AdminController::class, 'updateProject'])->name(name: 'updateProject');


// функции со страницы руководителя
Route::get('/editorAddProect', [EditorController::class, 'AllProject'])->name('editorAddProect');

Route::get('/allProject', action: [EditorController::class,'AllProject'])->name('AllProject');

Route::get('/editorProject/{id}/edit', [EditorController::class, 'editProject'])->name('editorUpdateProject');  
Route::put('/updateProject/{id}', [EditorController::class, 'updateProjectEditor'])->name('updateProjectEditor');
Route::get('/editor/projects', [EditorController::class, 'AllProject'])->name('editor.editorAddProject');
Route::delete('/project/{id}', [EditorController::class, 'destroyProject'])->name('destroyProject');

Route::get('/addProject', action: [EditorController::class,'AddProject'])->name('AddProject');
Route::get('/projects/create', [EditorController::class, 'AddProject'])->name('projects.create');
Route::post('/projects', [EditorController::class, 'store'])->name('projects.store');
Route::delete('/task/{id}', [EditorController::class, 'destroy'])->name('tasks.destroy');

Route::get('/taskEdit/{id}', [EditorController::class, 'tasksEdit'])->name('tasks.edit');
Route::post('/taskEditUpdate/{id}', [EditorController::class, 'tasksUpdate'])->name('tasks.update');

Route::get('/taskAdd/{id}', [EditorController::class, 'taskAdd'])->name('tasks.add');
Route::post('/tasks/{projectId}', [EditorController::class, 'storeTask'])->name('tasks.store');
Route::get('/infoTaskEditor/{id}', [EditorController::class, 'infoTaskEditor'])->name('infoTaskEditor');

Route::get('/projects/{project}/tasks', [EditorController::class, 'showTasks'])->name('project.tasks');


// функции для исполнителя/user
Route::get('/userAllTask', action: [UserController::class,'userAllTask'])->name('userAllTask');
Route::patch('/UserTasksUpdate/{id}', [UserController::class, 'UserTasksUpdate'])->name('UserTasksUpdate');
Route::post('/createComment', [UserController::class,'createComment'])->name('createComment');
// Route::get('/getCommentsForTask/{id}', action: [UserController::class,'getCommentsForTask'])->name('getCommentsForTask');



// статистика у админа 

Route::get('/projects/statistics', [AdminController::class, 'getProjectStatistics'])->name('getProjectStatistics');
Route::get('/projects/EditorStatistics', [EditorController::class, 'getEditorProjectStatistics'])->name('getEditorProjectStatistics');
Route::get('/user-statistics', action: [UserController::class, 'userTaskStatistics']);







