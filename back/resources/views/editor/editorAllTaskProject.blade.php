@extends('layouts.app')
@section('title', 'Задачи проекта: ' . $project->name)
@section('content')

<div class="container">
    <h1>Задачи проекта: {{ $project->name }}</h1>

    <div class="filter">
        <form method="GET" action="{{ route('project.tasks', $project->id) }}">
            <label for="priority">Фильтр по приоритету:</label>
            <select class="form-select" name="priority" id="priority">
                <option value="">Все</option>
                <option value="Высокий">Высокий</option>
                <option value="Средний">Средний</option>
                <option value="Низкий">Низкий</option>
            </select>
            <button type="submit">Применить</button>
        </form>
    </div>
    <div class="addTask"> 
<h2>Добавить задачу </h2>
<a href="{{ route('tasks.add', $project->id) }}"><img src="\images\icons8-плюс-24.png" alt="" class="img-add"></a>
</div>
    <div class="task-list">
        @foreach($tasks as $task)
        <div class="card border-success  mb-3" style="max-width: 18rem;">
        <div class="card-header">Название:{{ $task->name }}
      <div class="card-body">
          <p class="card-text">Описание:{{ $task->description }}</p>
          <p class="card-text">Дата начала: {{ $task->date_start }}</p>
          <p class="card-text">Дата окончания: {{ $task->date_end }}</p>
        </div>
        <div class="card-footer text-body-secondary">
          Статус: {{ $task->status }}<br>
          Приоритет: {{ $task->priority }}
        </div>
         <!-- Кнопка редактирования -->
         <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">
                        Редактировать
                    </a>
      <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
       <button type="submit" class="btn "
        onclick="return confirm('Вы уверены, что хотите удалить эту задачу?');">
        <img src="../../images/icons8-полная-корзина-30.png" alt="" srcset="">
        </button>
        </form>

        </div>
      </div>
    
        @endforeach
    </div>
<!-- пагинация -->
<div class="pagination">
        @if ($tasks->onFirstPage())
            <span class="disabled">&laquo; Предыдущая</span>
        @else
            <a href="{{ $tasks->previousPageUrl() }}">&laquo; Предыдущая</a>
        @endif

        @for ($i = 1; $i <= $tasks->lastPage(); $i++)
            @if ($i == $tasks->currentPage())
                <span class="current">{{ $i }}</span>
            @else
                <a href="{{ $tasks->url($i) }}">{{ $i }}</a>
            @endif
        @endfor

        @if ($tasks->hasMorePages())
            <a href="{{ $tasks->nextPageUrl() }}">Следующая &raquo;</a>
        @else
            <span class="disabled">Следующая &raquo;</span>
        @endif
    </div>
</div>
</div>

@endsection
