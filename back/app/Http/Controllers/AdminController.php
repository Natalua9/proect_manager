<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;




class AdminController extends Controller
{
    public function index()
    {
        return view('signin');
    
    }
   
    public function home(Request $request)
{
    // Если есть фильтр по роли, применяем его
    if ($request->has('role') && $request->role != '') {
        $users = User::where('role', $request->role)->where('role', '!=', 'admin')->get();
    } else {
        $users = User::where('role', '!=', 'admin')->get();
    }

    return response()->json($users);
}

public function project()
{ 
    $projects = Projects::with('projectTask')->get(); // Используем eager loading для загрузки задач
    foreach ($projects as &$project) {

        $project->manager = $project->id_manager ? User::find($project->id_manager)->name : 'нет руководителя';
    }
    return response()->json($projects);
}
    
    public function infoTask($id)
    {
        $tasks = Tasks::findOrFail($id);
        return view('admin.infoTask', compact('tasks'));
    }
    public function destroy($id) 
    { 
        $user = User::findOrFail($id); // Находим пользователя по ID 
        $user->delete(); // Удаляем пользователя 
        return response()->json(['success' => true, 'message' => 'Пользователь удален']); 
    }
    public function editUser($id)
{
    $user = User::findOrFail($id);
    $roles = ['user' => 'Исполнитель', 'editor' => 'Руководитель'];

    return response()->json([
        'user' => $user,
        'roles' => $roles
    ]);
}
    public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|in:user,editor',
    ]);

    $user = User::findOrFail($id);
    $user->update($request->only(['name', 'email', 'role']));

    return response()->json($user);
}
    public function editProject($id)
    {
        $project = Projects::findOrFail($id);
        $managers = User::where('role', 'editor')->get(); // Получаем всех редакторов
        return response()->json([
            'project' => $project,
            'managers' => $managers
        ]);
    }
    public function updateProject(Request $request, $id) 
    { 
        $request->validate([   
            'name' => 'required|string|max:255',   
            'id_manager' => 'required|exists:users,id', 
        ]);   
        $project = Projects::findOrFail($id);   
        $project->update([ 
            'name' => $request->name, 
            'id_manager' => $request->id_manager, // Сохраняем ID выбранного менеджера 
        ]);   
    
        return response()->json( $project);  
    }

//     // статистика
//     public function getProjectCount()
// {
//     return response()->json(Projects::count());
// }

// // Получение количества задач
// public function getTaskCount()
// {
//     return response()->json(Tasks::count());
// }

public function getProjectStatistics()
{
    $projects = Projects::withCount([
        'projectTask as total_tasks' => function ($query) {
            $query->select(DB::raw('count(*)'));
        },
        'projectTask as in_progress' => function ($query) {
            $query->where('status', 'Выполняется');
        },
        'projectTask as completed' => function ($query) {
            $query->where('status', 'Завершена');
        },
        'projectTask as new' => function ($query) {
            $query->where('status', 'Назначена');
        },
    ])->get();

    return response()->json($projects);
}
}
