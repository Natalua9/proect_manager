<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class EditorController extends Controller
{
    // вывод всех задач проекта на отдельной странице с фильтрацией и пагинацией
   
public function showTasks(Request $request, $id)
{
    $project = Projects::findOrFail($id);

   
     // Получаем все задачи проекта с комментариями
     $tasksQuery = $project->projectTask()->with(['comment.user' , 'user']);

    // Фильтрация по приоритету
    if ($request->has('priority') && $request->priority != '') {
        $tasksQuery->where('priority', $request->priority);
    }

    // Пагинация
    $tasks = $tasksQuery->paginate(5); // Пагинация на 5 задач на странице

    return response()->json(['tasks' => $tasks]);
}

    // //  вывод все проектов
    public function AllProject(Request $request)
    {
        $userId = $request->input('user_id');  // Извлекаем user_id из запроса

        // Находим пользователя по user_id
        $user = User::find($userId);
        if (!$user || !$user->projects) {
            abort(403, 'Доступ запрещен');
        }

        // Получаем проекты, принадлежащие пользователю
        $projects = $user->projects;


        return response()->json($projects);
    }

    // редактирование проекта
    public function editProject($id)
    {
        $project = Projects::findOrFail($id);
        $managers = User::where('role', 'editor')->get(); // Получаем всех менеджеров
        return response()->json(['project' => $project, 'managers' => $managers]);

    }
    public function updateProjectEditor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start', // Проверка, что дата окончания не раньше даты начала
        ]);

        $project = Projects::findOrFail($id);
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
        ]);
        return response()->json($project);

    }
    // удаление проекта
    public function destroyProject($id)
    {
        $project = Projects::findOrFail($id);
        $project->delete();
        return response()->json($project);
    }
    // подробнее о каждой задаче
    public function infoTaskEditor($id)
    {
        $tasks = Tasks::findOrFail($id);
        return view('editor.infoTaskEditor', compact('tasks'));
    }
    // удаление задач
    public function destroy($id)
    {
        $task = Tasks::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Задача успешно удалена']);
    }

    // создание проекта
    public function AddProject()
    {
        $projects = Projects::all();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        if (
            $request->validate([
                'name' => 'required|string|max:255|min:3|unique:projects,name',
                'description' => 'required|string',
                'date_start' => 'required|date',
                'date_end' => 'required|date|after_or_equal:date_start',
                // 'id_manager' => 'required|exists:users,id',
            ])
        ) {

            $project = Projects::create([
                'name' => $request->name,
                'description' => $request->description,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
                'id_manager' => $request->id,
            ]);

            return response()->json($project);
        } else {
            return response()->json(' Ошибка валидации');
        }
    }


    // для создания задач
    public function taskAdd($projectId)
    {
        $tasks = Projects::findOrFail($projectId);
        $editors = User::where('role', 'user')->get();

        return response()->json([
            'tasks' => $tasks,
            'editors' => $editors
        ]);
    }


   
    public function storeTask(Request $request)
    {
        $validPriorities = ['Низкий', 'Средний', 'Высокий'];

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'id_manager' => 'required|exists:users,id',
            'priority' => 'required|in:' . implode(',', $validPriorities), // Валидация для приоритета 
        ]);

        // Получаем проект, к которому относится задача
        $project = Projects::findOrFail($request->projectId);

        // Проверяем, что дата начала задачи не раньше даты начала проекта
        if ($validatedData['date_start'] < $project->date_start) {
            return response()->json([
                'error' => 'Дата начала задачи не может быть раньше даты начала проекта.'
            ], 422); // Код ошибки 422 для валидации
        }

        $task = Tasks::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'date_start' => $validatedData['date_start'],
            'date_end' => $validatedData['date_end'],
            'id_user' => $validatedData['id_manager'],
            'id_project' => $request->projectId,
            'priority' => $validatedData['priority'], // Сохраняем приоритет
        ]);

        return response()->json(['tasks' => $task]);
    }

    // // для редактирования задач
    public function tasksEdit($id)
    {
        $task = Tasks::findOrFail($id); // Получаем задачу по ID 
        $editors = User::where('role', 'user')->get();

        // return view('editor.taskEditEditor', compact('task')); 
        return response()->json([
            'task' => $task,
            'editors' => $editors
        ]);

    }

    public function tasksUpdate(Request $request, $id)
    {
        $validStatuses = ['Назначена', 'Выполняется', 'Завершена'];
        $validPriorities = ['Низкий', 'Средний', 'Высокий'];

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:' . implode(',', $validStatuses),
            'priority' => 'required|in:' . implode(',', $validPriorities),
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'id_user' => 'required',
        ]);

        $task = Tasks::findOrFail($id);
        $task->update($validatedData);

        return response()->json($task);
        // return response()->json(['message' => 'Задача успешно обновлена']);
    }

    // статистика дописать !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    public function getEditorProjectStatistics(Request $request)
    {
        try {
            $userId = $request->input('user_id');  
            $user = User::find($userId);  
            if (!$user) {
                abort(403, 'Доступ запрещен');
            }
    
            $projects = Projects::withCount([ 
                'projectTask as total_tasks' => function ($query) use ($user) { 
                    $query->where('id_manager', $user->id); 
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
            ])
            ->where('id_manager', $user->id) // Фильтруем проекты по текущему пользователю
            ->get(); 
                
                return response()->json($projects);
    
            // Преобразование статистики...
        } catch (\Exception $e) {
            // Логирование ошибки
            Log::error('Ошибка получения статистики: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка на сервере.'], 500);

        }
    }

}
