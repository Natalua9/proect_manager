<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Models\Tasks;
use Illuminate\Support\Facades\DB;




class UserController extends Controller
{
    public function userAllTask(Request $request)  
    {  
        $userId = $request->input('user_id');  
        $user = User::find($userId);  
        if (!$user || !$user->tasks) {
            abort(403, 'Доступ запрещен');
        }
    
        $tasksQuery = $user->tasks();
    
        // Фильтрация по приоритету
        if ($request->has('priority') && $request->priority != '') {
            $tasksQuery->where('priority', $request->priority);
        }
    
        // Пагинация
        $tasks = $tasksQuery->paginate(5); 
        return response()->json($tasks); 
    }
    
    public function UserTasksUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
        ]);
    
        $task = Tasks::findOrFail($id);
        $task->update($validatedData);
        return response()->json(['success' => true, 'message' => 'Статус задачи успешно обновлен'], 200);
    }
    
    public function createComment(Request $request){
        $validatedData = $request->validate([  
            'content' => 'string|max:255',  
        ]);
    
       $comment =  Comment::create([ 
        'content' => $validatedData['content'], 
        'id_task' => $request->input('taskId'), 
        'id_user' =>  $request->input('userId'),
        ]); 
        return response()->json(['comment' => $comment]);
    }
 
    // public function getCommentsForTask($taskId)
    // {
    //     $comments = Comment::where('task_id', $taskId)->get();
    //     return response()->json($comments);
    // }
    public function userTaskStatistics(Request $request)  
{  
    $userId = $request->input('user_id');  
    $user = User::find($userId);  
    if (!$user) {
        abort(403, 'Доступ запрещен');
    }
    
    // Получаем статистику по задачам
    $tasks = $user->tasks()->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get();

    // Преобразуем в массив
    $stats = [
        'total_tasks' => 0,
        'new' => 0,
        'in_progress' => 0,
        'completed' => 0,
    ];

    foreach ($tasks as $task) {
        $stats['total_tasks'] += $task->total;
        if ($task->status === 'Назначена') {
            $stats['new'] += $task->total;
        } elseif ($task->status === 'Выполняется') {
            $stats['in_progress'] += $task->total;
        } elseif ($task->status === 'Завершена') {
            $stats['completed'] += $task->total;
        }
    }

    return response()->json($stats);
}
   
}
