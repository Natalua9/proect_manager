@extends('layouts.app')  
@section('title', 'Проекты')  
@section('content')  

<div class="contant">
  <div class="menu-left">
    <!-- <a href="{{ route('home') }}" type="button" class="btn btn-light">Пользователи</a>  
        <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a> -->
  </div>

  <div class="container">
    <h1>Задачи исполнителя</h1>
    <div class="filter">
      <form method="GET" action="">
        <label for="priority">Фильтр по приоритету:</label>
        <select class="form-select" name="priority" id="priority" onchange="this.form.submit()">
          <option value="">Все</option>
          <option value="Высокий" {{ request('priority') == 'Высокий' ? 'selected' : '' }}>Высокий</option>
          <option value="Средний" {{ request('priority') == 'Средний' ? 'selected' : '' }}>Средний</option>
          <option value="Низкий" {{ request('priority') == 'Низкий' ? 'selected' : '' }}>Низкий</option>
        </select>
      </form>
    </div>
    <div class="all-task">
      @if($tasks->isEmpty())
      <p>У вас нет задач с данным приоритетом</p>
    @else
      @foreach($tasks as $task)   
      <div class="card border-success mb-3" style="max-width: 18rem;">
      <div class="card-body">
      <h5 class="card-title">Название: {{ $task->name }}</h5>
      <p class="card-text">Описание: {{ $task->description }}</p>
      <p class="card-text">Дата начала: {{ $task->date_start }}</p>
      <p class="card-text">Дата окончания: {{ $task->date_end }}</p>
      </div>
      <div class="card-footer text-body-secondary">
      <form action="{{ route('UserTasksUpdate', $task->id) }}" method="POST">
      @csrf
      @method('PUT') 
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="Назначена" id="status1_{{ $task->id }}"
        {{ $task->status == 'Назначена' ? 'checked' : '' }}>
        <label class="form-check-label" for="status1_{{ $task->id }}">Назначена</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="Выполняется"
        id="status2_{{ $task->id }}" {{ $task->status == 'Выполняется' ? 'checked' : '' }}>
        <label class="form-check-label" for="status2_{{ $task->id }}">Выполняется</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="Завершена" id="status3_{{ $task->id }}"
        {{ $task->status == 'Завершена' ? 'checked' : '' }}>
        <label class="form-check-label" for="status3_{{ $task->id }}">Завершена</label>
      </div>
      <button type="submit" class="btn btn-primary">Сохранить статус</button>
      </form>
      Приоритет: {{ $task->priority }}
      </div>
      <div class="commentary">  <p>Оставить комментарий</p>

      <img src="../../images\icons8-комментарии-48.png" alt="" class="img-comment"></div>
    
      </div>
    @endforeach

      <!-- Пагинация -->
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
  @endif
  </div>
</div>
</div>

@endsection
