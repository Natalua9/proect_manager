@extends('layouts.app')
@section('title', 'Проекты')
@section('content')

<div class="contant">
  <div class="menu-left">
    <!-- <a href="{{ route('home') }}" type="button" class="btn btn-light">Пользователи</a>
    <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a> -->
  </div>

  <div class="container">
    <h1>Проекты руководителя</h1>
    <div class="all-project">
      @foreach($projects as $key => $project) 

      <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Название проекта:
        {{ $project->name }}
        </h5>
        <h5 class="card-title">Руководитель:{{ $project->user->name  }}</h5>
        <p class="card-text"> {{ $project->description }}</p>
        <p class="card-text">Дата начала:{{ $project->date_start }}</p>
        <p class="card-text">Дата окончания:{{ $project->date_end }}</p>
        <div class="addTask"> 
        <h4>Задачи:</h4>
<a href="{{ route('tasks.add', $project->id) }}"><img src="\images\icons8-плюс-24.png" alt=""></a>
        </div>
        <a href="{{ route('project.tasks', $project->id) }}">Посмотреть задачи</a>
        <div class="card-body">
        <p class="card-text">Статус:{{ $project->status }}</p>
        <a href="{{ route('editorUpdateProject', $project->id) }}"><button type="button"
          class="btn btn-success">Изменить</button></a>
        <form action="{{ route('destroyProject', $project->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger"
          onclick="return confirm('Вы уверены, что хотите удалить этот проект?');">Удалить</button>
        </form>
        </div>
      </div>
      </div>

    @endforeach

    </div>
  </div>
  @endsection('content')